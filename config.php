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


//Queries voor klant tabel
function Get_klant_with_klantID($klantid) {
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

function Get_klant_with_email($email){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM klanten WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}

function Insert_klant($naam_klant, $wachtwoord, $email, $tel_nr){
    $stmt = $GLOBALS['con']->prepare("INSERT INTO `klanten`(`naam_klant`, `wachtwoord`, `email`, `tel_nr`) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $naam_klant, $wachtwoord, $email, $tel_nr);
    $stmt->execute();
}

function Update_klant_WW_Gebrnaam_with_klantID($wachtwoord, $gebr_naam, $klant_id){
    $stmt = $GLOBALS['con']->prepare("UPDATE klanten SET wachtwoord = ?, gebr_naam = ? WHERE klant_id = ?");
    $stmt->bind_param("sss", $wachtwoord, $gebr_naam, $klant_id);
    $stmt->execute();
}

function Update_klant_WW_with_Gebrnaam($wachtwoord, $gebr_naam){
    $stmt = $GLOBALS['con']->prepare("UPDATE klanten SET wachtwoord = ? WHERE gebr_naam = ?");
    $stmt->bind_param("ss", $wachtwoord, $gebr_naam);
    $stmt->execute();
}

function Count_klant_with_ww_Gebrnaam($wachtwoord, $gebr_naam){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM klanten WHERE gebr_naam = ? AND wachtwoord = ?");
    $stmt->bind_param("ss", $gebr_naam, $wachtwoord);
    $stmt->execute();
    return $stmt->get_result()->num_rows;
}

function Count_klant_with_Telnr($tel_nr){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM klanten WHERE tel_nr = ? ");
    $stmt->bind_param("s", $tel_nr);
    $stmt->execute();
    return $stmt->get_result()->num_rows;
}

function Count_klant_with_Gebrnaam($gebr_naam){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM klanten WHERE gebr_naam = ? ");
    $stmt->bind_param("s", $gebr_naam);
    $stmt->execute();
    return $stmt->get_result()->num_rows;
}




//Queries voor stempelkaart tabel
function Get_kaart_with_kaartID($kaartid){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM stempelkaarten WHERE stempelkaart_id = ?");
    $stmt->bind_param("s", $kaartid);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}

function Get_kaarten_with_ondID($ondernemer_id){
    $stmt = $GLOBALS['con']->prepare("SELECT  * FROM stempelkaarten WHERE ondernemer_id = ? ORDER BY stempelkaart_id");
    $stmt->bind_param("s", $ondernemer_id);
    $stmt->execute();
    return $stmt->get_result();
}

function Get_kaart_with_kaartID_ondID($stempelkaartid, $ondernemer_id){
    $stmt = $GLOBALS['con']->prepare("SELECT  * FROM stempelkaarten WHERE ondernemer_id = ? AND stempelkaart_id = ?");
    $stmt->bind_param("ss", $ondernemer_id, $stempelkaartid);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}

function Insert_kaart($ondernemer_id, $beloning_aantstemps, $beloning_label, $beloning_beschrijving){
    $stmt = $GLOBALS['con']->prepare("INSERT INTO `stempelkaarten`(`ondernemer_id`, `beloning_aantstemps`, `beloning_label`, `beloning_beschrijving`) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $ondernemer_id, $beloning_aantstemps, $beloning_label, $beloning_beschrijving);
    $stmt->execute();
}

function Update_kaart_aantstemp_label_besch_with_kaartID($aant_stemps, $label, $beschrijving, $kaartID){
    $stmt = $GLOBALS['con']->prepare("UPDATE stempelkaarten SET beloning_aantstemps = ?, beloning_label = ?, beloning_beschrijving = ? WHERE stempelkaart_id = ?");
    $stmt->bind_param("ssss", $aant_stemps, $label, $beschrijving, $kaartID);
    $stmt->execute();
}

function Delete_kaart_with_kaartID ($kaartID) {
    $stmt = $GLOBALS['con']->prepare("DELETE FROM stempelkaarten WHERE stempelkaart_id = ?");
    $stmt->bind_param("s", $kaartID);
    $stmt->execute();
}



//Queries voor ondernemers tabel
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

function Get_ondernemer_with_telnr($telnr){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM ondernemers WHERE tel_nr = ?");
    $stmt->bind_param("s", $telnr);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}

function Get_ondernemer_with_email($email){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM ondernemers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}

function Get_ondernemer_with_kvk($kvk){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM ondernemers WHERE kvk = ?");
    $stmt->bind_param("s", $kvk);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}

function Insert_ondernemer($bedrijfsnaam, $gebr_naam, $wachtwoord, $email, $telnr, $stempafb, $kvk){
    $stmt = $GLOBALS['con']->prepare("INSERT INTO `ondernemers`(`bedrijfsnaam_ond`, `gebr_naam`, `wachtwoord`, `email`, `tel_nr`,`stemp_afb`,`kvk`) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $bedrijfsnaam, $gebr_naam, $wachtwoord, $email, $telnr, $stempafb, $kvk);
    $stmt->execute();
}

function Update_ondernemer_ww_with_Gebrnaam ($wachtwoord, $gebr_naam){
    $stmt = $GLOBALS['con']->prepare("UPDATE ondernemers SET wachtwoord = ? WHERE gebr_naam = ?");
    $stmt->bind_param("ss", $wachtwoord, $gebr_naam);
    $stmt->execute();
}

function Update_ondernemer_bedrnaam_email_telnr_kvk_with_Gebrnaam($bedr_naam, $email, $tel_nr, $kvk, $gebr_naam){
    $stmt = $GLOBALS['con']->prepare("UPDATE ondernemers SET bedrijfsnaam_ond = ?, email = ?, tel_nr = ?, kvk = ? WHERE gebr_naam = ?");
    $stmt->bind_param("sssss", $bedr_naam, $email, $tel_nr, $kvk, $gebr_naam);
    $stmt->execute();
}

function Update_ondernemer_logo_with_Gebrnaam($target, $gebr_naam){
    $stmt = $GLOBALS['con']->prepare("UPDATE ondernemers SET logo = ? WHERE gebr_naam = ?");
    $stmt->bind_param("ss", $target, $gebr_naam);
    $stmt->execute();
}

function Update_ondernemer_stemp_afb_with_Gebrnaam($target, $gebr_naam){
    $stmt = $GLOBALS['con']->prepare("UPDATE ondernemers SET stemp_afb = ? WHERE gebr_naam = ?");
    $stmt->bind_param("ss", $target, $gebr_naam);
    $stmt->execute();
}

function Update_ondernemer_kleur1_with_Gebrnaam($kleur1, $gebr_naam){
    $stmt = $GLOBALS['con']->prepare("UPDATE ondernemers SET kleur1 = ? WHERE gebr_naam = ?");
    $stmt->bind_param("ss", $kleur1, $gebr_naam);
    $stmt->execute();
}

function Update_ondernemer_kleur2_with_Gebrnaam($kleur2, $gebr_naam){
    $stmt = $GLOBALS['con']->prepare("UPDATE ondernemers SET kleur2 = ? WHERE gebr_naam = ?");
    $stmt->bind_param("ss", $kleur2, $gebr_naam);
    $stmt->execute();
}

function Count_ondernemer_with_ww_Gebrnaam($wachtwoord, $gebr_naam){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM ondernemers WHERE gebr_naam = ? AND wachtwoord = ?");
    $stmt->bind_param("ss", $gebr_naam, $wachtwoord);
    $stmt->execute();
    return $stmt->get_result()->num_rows;
}

function Count_ondernemer_with_Gebrnaam($gebr_naam){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM ondernemers WHERE gebr_naam = ?");
    $stmt->bind_param("s", $gebr_naam);
    $stmt->execute();
    return $stmt->get_result()->num_rows;
}






//Queries voor stempelkaart_klant tabel
function Get_link_with_kaartID($kaartid){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM stempelkaart_klant WHERE stempelkaart_id = ?");
    $stmt->bind_param("s", $kaartid);
    $stmt->execute();
    return $stmt->get_result();
}

function Get_link_with_klantID($klant_id){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM stempelkaart_klant WHERE klant_id = ?");
    $stmt->bind_param("s", $klant_id);
    $stmt->execute();
    return $stmt->get_result();
}

function Get_link_with_kaartID_klantID($klantid, $kaartid){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM stempelkaart_klant WHERE klant_id = ? AND stempelkaart_id = ?");
    $stmt->bind_param("ss", $klantid, $kaartid);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
}

function Insert_Link($klant_id, $stempelkaart_id, $aant_stemps){
    $stmt = $GLOBALS['con']->prepare("INSERT INTO `stempelkaart_klant`(`klant_id`, `stempelkaart_id`,`aant_stemps`) VALUES (?,?,?)");
    $stmt->bind_param("sss", $klant_id, $stempelkaart_id, $aant_stemps);
    $stmt->execute();
}

function Update_aantstemps_with_kaartID_klantID($aantstemps, $kaartid, $klantid){
    $stmt = $GLOBALS['con']->prepare("UPDATE stempelkaart_klant SET aant_stemps = ? WHERE klant_id = ? AND stempelkaart_id = ?");
    $stmt->bind_param("sss", $aantstemps ,$klantid, $kaartid);
    $stmt->execute();
}

function Update_kaartID_aantstemps_with_klantID_kaartID($newkaartid, $aantstemps, $klantid, $kaartid){
    $stmt = $GLOBALS['con']->prepare("UPDATE stempelkaart_klant SET kaartid = ?, aant_stemps = ? WHERE klant_id = ? AND stempelkaart_id = ?");
    $stmt->bind_param("ssss", $newkaartid,$aantstemps ,$klantid, $kaartid);
    $stmt->execute();
}

function Count_link_with_kaartID_klantID($klantid, $kaartid){
    $stmt = $GLOBALS['con']->prepare("SELECT * FROM stempelkaart_klant WHERE klant_id = ? AND stempelkaart_id = ?");
    $stmt->bind_param("ss", $klantid, $kaartid);
    $stmt->execute();
    return $stmt->get_result()->num_rows;
}
?>

