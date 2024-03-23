<?php
$server = "localhost";
$User = "root";
$password = "";
$databases = "dbjualan.sql";

$db = mysqli_connect($server,$User,$password,$databases);
if(!$db) {
	die("Gagal Terhubung dengan Database: " .mysqli_connect_error());
}
?>