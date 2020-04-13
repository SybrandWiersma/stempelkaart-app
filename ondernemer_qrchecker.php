<?php
include("config.php");

// Haalt de data op die meegestuurd is met de x
$gebruiker_id = $_REQUEST["klant_id"];
$ondernemer_gebr_naam = $_REQUEST["ondernemer_gebr_naam"];

// Zoekt ondernemer op in database met gebruikersnaam van ondernemer
$query_ondernemingID = "SELECT ondernemer_id FROM ondernemers WHERE gebr_naam = '".$ondernemer_gebr_naam."';";
$result_ondernemingID = mysqli_query($con, $query_ondernemingID);
$row_ondernemingID = mysqli_fetch_array($result_ondernemingID);

// Zoekt het stempelkaart id op en het aantal stempels die de klant heeft verzameld
$query_aantstemps = "SELECT aant_stemps, stempelkaart_id FROM stempelkaart_klant WHERE klant_id = '".$gebruiker_id."' AND stempelkaart_id IN (SELECT stempelkaart_id FROM stempelkaarten WHERE ondernemer_id = '".$row_ondernemingID['ondernemer_id']."')";
$result_aantstemps = mysqli_query($con,$query_aantstemps);
$row_aantstemps = mysqli_fetch_array($result_aantstemps);

// Zoekt het maximale aantal stempels op dat kan worden gehaald op een stempelkaart
$query_maxstemps = "SELECT beloning_aantstemps FROM stempelkaarten WHERE stempelkaart_id = '".$row_aantstemps['stempelkaart_id']."';";
$result_maxstemps = mysqli_query($con, $query_maxstemps);
$row_maxstemps = mysqli_fetch_array($result_maxstemps);

// Zoekt de gebruikersdata op van een gebruiker
$query_gebruikerdata = "SELECT * FROM klanten WHERE klant_id = '".$gebruiker_id."';";
$result_gebruikerdata = mysqli_query($con,$query_gebruikerdata);
$row_gebruikerdata = mysqli_fetch_array($result_gebruikerdata);


if(isset($row_gebruikerdata))
{
    // Stuurt een list item op met de data en styling die worden gevraagd
    echo "<li style=\"list-style: none; border: 1px solid black; border-radius: 5px; margin-right: 10%; margin-top: 10%; padding: 4%\"><strong>" . $row_gebruikerdata['naam_klant'] . "<br> " . $row_aantstemps['aant_stemps'] . " / " . $row_maxstemps['beloning_aantstemps'] . " </strong> stempels <br><br> <button style='border-radius: 5px; width: auto; background-color: #5cc30c' onclick=\"location.href='ondernemer_qrcode_gescand.php?kaartid=".$row_aantstemps['stempelkaart_id']."&klantid=".$row_gebruikerdata['klant_id']."'\">Ga naar kaart</button> </li> ";
}
else
{
    // wanneer een row_gebruikersdata leeg is dus als er geen kaart kan worden gevonden word een error list item gestuurd
    echo "<li style=\"list-style: none; border: 1px solid black; border-radius: 5px; margin-right: 10%; margin-top: 10%; padding: 4%\"><strong style=\"color: red;\">Kaart niet gevonden</strong></li>";
}