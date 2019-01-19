<?php
class User {

    // database connection and table name
    private $conn;
    private $table_name = "users";

    // object properties
    public $id;
    public $name;
    public $username;
    public $password;

    // constructor with $db as database connection
    public function __construct($conn){
        $this->conn = $conn;
    }

    function usernameExists() {
        $query = "SELECT * FROM users where username = '$this->username'";
        $result = mysqli_query($this->conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->password = $row['password'];
            }
            return true;
        } else {
            return false;
        }
    }

}
?>