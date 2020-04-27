<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "stempelkaartapp";

$con = mysqli_connect($host, $user, $password, $dbname);
// Checken of er verbinding is
if (!$con) {
    die("Verbinding mislukt: " . mysqli_connect_error());
}

//Klant gegevens ophalen
function Get_klant_with_ID($klantid) {
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM klanten WHERE klant_id = ?");
    $stmt->bind_param("s", $klantid);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}

function Get_klant_with_Telnr($telnr){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM klanten WHERE tel_nr = ?");
    $stmt->bind_param("s", $telnr);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}

function Get_klant_with_Gebrnaam($gebr_naam){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM klanten WHERE gebr_naam = ?");
    $stmt->bind_param("s", $gebr_naam);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}

function Update_klanten_WW_Gebrnaam_with_klantID($wachtwoord, $gebr_naam, $klant_id){
    $stmt = $GLOBALS['con']->prepare("UPDATE klanten SET wachtwoord = ?, gebr_naam = ? WHERE klant_id = ?");
    $stmt->bind_param("sss", $wachtwoord, $gebr_naam, $klant_id);
    $stmt->execute();
}





function Get_kaart_with_ID($kaartid){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM stempelkaarten WHERE stempelkaart_id = ?");
    $stmt->bind_param("s", $kaartid);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}






function Get_ondernemer_with_ID($ondid){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM ondernemers WHERE ondernemer_id = ?");
    $stmt->bind_param("s", $ondid);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}

function Get_ondernemer_with_Gebrnaam($gebr_naam){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM ondernemers WHERE gebr_naam = ?");
    $stmt->bind_param("s", $gebr_naam);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}






function Get_link_with_kaartID($kaartid){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM stempelkaart_klant WHERE kaartid = ?");
    $stmt->bind_param("s", $kaartid);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}
?>

