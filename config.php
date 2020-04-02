<?php
<?php
session_start();
$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "stempelkaartapp"; 

$con = mysqli_connect($host, $user, $password,$dbname);
// Checken of er verbinding is
if (!$con) {
 die("Verbinding mislukt: " . mysqli_connect_error());


?>
