<?php
include("config.php");

// Haalt de data op die meegestuurd is met de request
$klant_id = $_POST['klantid'];
$kaart_id = $_POST['kaartid'];


// Haalt data op uit database
$linkdata = Get_link_with_kaartID_klantID($kaart_id, $klant_id);
$kaartdata = Get_kaart_with_kaartID($kaart_id);
$klantdata = Get_klant_with_klantID($klant_id);


if (isset($kaartdata)) {
    // Stuurt een list item op met de data en styling die worden gevraagd
    echo "<li style=\"list-style: none; border: 1px solid black; border-radius: 5px; margin-right: 10%; margin-top: 10%; padding: 4%\"><strong>" . $klantdata->naam_klant . "<br> " . $linkdata->aant_stemps . " / " . $kaartdata->beloning_aantstemps . " </strong> stempels <br><br> <button style='border-radius: 5px; width: auto; background-color: #5cc30c' onclick=\"location.href='ondernemer_qrcode_gescand.php?kaartid=" . $kaart_id . "&klantid=" . $klant_id . "'\">Ga naar kaart</button> </li> ";
} else {
    // wanneer een row_gebruikersdata leeg is dus als er geen kaart kan worden gevonden word een error list item gestuurd
    echo "<li style=\"list-style: none; border: 1px solid black; border-radius: 5px; margin-right: 10%; margin-top: 10%; padding: 4%\"><strong style=\"color: red;\">Kaart niet gevonden</strong></li>";
}