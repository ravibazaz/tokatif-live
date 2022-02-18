<?php

error_reporting(1);
date_default_timezone_set('Asia/Kolkata');

$host = 'localhost';
$user = 'tokatifc_staging';
$password = 'g(B(uW&duNBG';
$database = 'tokatifc_staging';


$con = mysqli_connect($host,$user,$password,$database);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

?>

