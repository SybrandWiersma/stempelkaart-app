<?php
include("config.php");

$gebruiker_id = $_REQUEST["scan"];
$ondernemer_id = $_REQUEST[""];

$query_aantstemps = "SELECT aant_stemps FROM stempelkaart_klant WHERE klant_id = '".$gebruiker_id."' AND stempelkaart_id IN (SELECT stempelkaart_id FROM stempelkaarten WHERE ondernemer_id = '".$ondernemer_id."')";
$result_aantstemps = mysqli_query($con,$query_aantstemps);
$row_aantstemps = mysqli_fetch_array($result_aantstemps);

$query_gebruikerdata = "SELECT * FROM klanten WHERE klant_id = '".$gebruiker_id."';";
$result_gebruikerdata = mysqli_query($con,$query_gebruikerdata);
$row_gebruikerdata = mysqli_fetch_array($result_gebruikerdata);



echo "Klant naam:".$row_gebruikerdata['gebr_naam'].", aantal stempels: ".$row_aantstemps['aant_stemps']  ;