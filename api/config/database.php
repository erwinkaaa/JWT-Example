<?php
class Database{

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "world";
    private $username = "root";
    private $password = "";
    public $conn;

    // get the database connection
    public function getConnection() {

        $this->conn = null;

        $this->conn = mysqli_connect($this->host,$this->username,$this->password,$this->db_name);
        if(mysqli_connect_errno()){
            die("ERROR : " . mysqli_connect_error());
        }

        return $this->conn;
    }
}
?>