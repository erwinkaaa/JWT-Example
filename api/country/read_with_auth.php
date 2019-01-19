<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/country.php';

// required to decode jwt
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

// get posted data
$data = json_decode(file_get_contents("php://input"));

// get jwt
$jwt = isset($data->jwt) ? $data->jwt : "";

// if jwt is not empty
if ($jwt) {

    // if decode succeed, show user details
	try {
        // decode jwt
		$decoded = JWT::decode($jwt, $key, array('HS256'));

		// instantiate database and product object
		$database = new Database();
		$conn = $database->getConnection();

		// initialize object
		$country = new Country($conn);

		// query products
		$result = $country->read();
		$num = mysqli_num_rows($result);

		if ($num > 0) {

			$body = array();
			$body['records'] = array();

			while($row = mysqli_fetch_array($result)) {

				$world_item = array(
					"Code" => $row['Code'],
					"Name" => $row['Name'],
					"Continent" => $row['Continent'],
					"Region" => $row['Region'],
					"SurfaceArea" => $row['SurfaceArea'],
					"IndepYear" => $row['IndepYear'],
					"Population" => $row['Population'],
					"LifeExpectancy" => $row['LifeExpectancy'],
					"GNP" => $row['GNP'],
					"GNPOld" => $row['GNPOld'],
					"LocalName" => $row['LocalName'],
					"GovernmentForm" => $row['GovernmentForm'],
					"HeadOfState" => $row['HeadOfState'],
					"Capital" => $row['Capital'],
					"Code2" => $row['Code2'],
				);

				array_push($body['records'], $world_item);
			}

			// set response code - 200 OK
			http_response_code(200);

			// if 'Malformed UTF-8 characters, possibly incorrectly encoded' occured
			$body['records'] = mb_convert_encoding($body['records'], 'UTF-8', 'UTF-8');

    		// show products data in json format
			echo json_encode($body);

			// show if any error occured
			// echo json_last_error_msg();

		} else {
			// set response code - 404 Not found
			http_response_code(404);

    		// tell the user no products found
			echo json_encode(
				array("message" => "No datas found.")
			);
		}

	}

	// if decode fails, it means jwt is invalid
	catch (Exception $e) {

    // set response code
		http_response_code(401);

    // tell the user access denied  & show error message
		echo json_encode(
			array(
				"message" => "Access denied.",
				"error" => $e->getMessage()
			)
		);
	}
}
// show error message if jwt is empty
else {

    // set response code
	http_response_code(401);

    // tell the user access denied
	echo json_encode(array("message" => "Access denied."));
}

?>