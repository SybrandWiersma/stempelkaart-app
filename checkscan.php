<?php
include("config.php");

$gebruiker_id = $_REQUEST["klant_id"];
$ondernemer_gebr_naam = $_REQUEST["ondernemer_gebr_naam"];

$query_ondernemingID = "SELECT ondernemer_id FROM ondernemers WHERE gebr_naam = '".$ondernemer_gebr_naam."';";
$result_ondernemingID = mysqli_query($con, $query_ondernemingID);
$row_ondernemingID = mysqli_fetch_array($result_ondernemingID);


$query_aantstemps = "SELECT aant_stemps FROM stempelkaart_klant WHERE klant_id = '".$gebruiker_id."' AND stempelkaart_id IN (SELECT stempelkaart_id FROM stempelkaarten WHERE ondernemer_id = '".$row_ondernemingID['ondernemer_id']."')";
$result_aantstemps = mysqli_query($con,$query_aantstemps);
$row_aantstemps = mysqli_fetch_array($result_aantstemps);

$query_gebruikerdata = "SELECT * FROM klanten WHERE klant_id = '".$gebruiker_id."';";
$result_gebruikerdata = mysqli_query($con,$query_gebruikerdata);
$row_gebruikerdata = mysqli_fetch_array($result_gebruikerdata);



echo "Klant naam:".$row_gebruikerdata['gebr_naam'].", aantal stempels: ".$row_aantstemps['aant_stemps']  ;