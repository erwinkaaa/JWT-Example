<?php
class Country {

    // database connection and table name
    private $conn;
    private $table_name = "country";

    // object properties
    public $code;
    public $name;
    public $continent;
    public $region;
    public $surface_area;
    public $indep_year;
    public $population;
    public $life_expentancy;
    public $gnp;
    public $gnp_old;
    public $local_name;
    public $goverment_form;
    public $head_of_state;
    public $capital;
    public $code2;

    // constructor with $db as database connection
    public function __construct($conn){
        $this->conn = $conn;
    }

    function read() {

        $query = "SELECT * FROM $this->table_name";
        $result = mysqli_query($this->conn, $query);

        return $result;
    }

    function readPaging($from_record_num, $records_per_page) {

        $query = "SELECT * FROM $this->table_name LIMIT $from_record_num , $records_per_page";
        $result = mysqli_query($this->conn, $query);

        return $result;
    }

    // used for paging products
    function count() {
        $count = 0;

        $query = "SELECT COUNT(*) as total_rows FROM $this->table_name";
        $result = mysqli_query($this->conn, $query);

        while($row = mysqli_fetch_array($result)) {
            $count = $row['total_rows'];
        }

        return $count;
    }
}