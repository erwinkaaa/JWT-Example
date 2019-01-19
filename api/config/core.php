<?php
// show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// set your default time-zone
date_default_timezone_set('Asia/Jakarta');

//--------------------------------------------------------------------------- PAGING
 
// home page url
$home_url = "http://localhost:90/project-name/api/";
 
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
// set number of records per page
$records_per_page = 20;
 
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

//--------------------------------------------------------------------------- JWT

//If your private key contains \n characters, be sure to wrap it in double quotes "" and not single quotes '' in order to properly interpret the escaped characters.

// variables used for jwt
$key = "example_key";

$iss = "http://example.org";
$aud = "http://example.com";
$iat = 1547890148;
$nbf = 1548890148;

?>