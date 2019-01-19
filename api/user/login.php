<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost:90/project-sample/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// files needed to connect to database
include_once '../config/database.php';
include_once '../objects/user.php';

// generate json web token
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

// get database connection
$database = new Database();
$conn = $database->getConnection();

// instantiate user object
$user = new User($conn);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
$user->username = $data->username;
$username_exists = $user->usernameExists();

// check if username exists and if password is correct
if ($username_exists) {

	if (password_verify($data->password, $user->password)) {

		$token = array(
			"data" => array(
				"id" => $user->id,
				"name" => $user->name,
				"username" => $user->username,
				"password" => $user->password
			)
		);

		// set response code
		http_response_code(200);

    	// generate jwt
		$jwt = JWT::encode($token, $key);
		echo json_encode(
			array(
				"message" => "Successful login.",
				"jwt" => $jwt
			)
		);

	} else {
		// set response code
		http_response_code(401);

    	// tell the user login failed
		echo json_encode(array("message" => "Wrong password."));
	}

}
// login failed
else{

    // set response code
	http_response_code(401);

    // tell the user login failed
	echo json_encode(array("message" => "Username not found."));
}
?>

