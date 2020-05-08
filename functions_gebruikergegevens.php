<?php

function CreateMessage ($message){

    if($message[0] == 'F'){
        return "<strong>Fout! </strong>".substr($message, 1)."</br>";
    }

    if ($message[0] == "G"){
        return "<strong>Gelukt! </strong>".substr($message, 1)."</br>";
    }

    return $message;
}



function UpdateWachtwoord($wachtwoord_oud, $wachtwoord_nieuw, $wachtwoord_herhaald, $gebruikerdata, $ondernemer_of_klant){


    if ($wachtwoord_oud == '' || $wachtwoord_nieuw == '' || $wachtwoord_herhaald == '') {
        return "FHet is verplicht om alle velden in te vullen!";
    }

    // Check of oude wachtwoord klopt
    if ($wachtwoord_oud != $gebruikerdata->wachtwoord) {
        return "FUw oude wachtwoord klopt niet";
    }

    // Check of oude wachtwoord klopt
    if ($wachtwoord_oud == $wachtwoord_nieuw) {
       return "FUw nieuwe wachtwoord mag niet hetzelfde zijn als uw oude wachtwoord";
    }

    // Check of de wachtwoorden exact hetzelfde zijn
    if ($wachtwoord_nieuw != $wachtwoord_herhaald){
        return "FNieuwe wachtwoorden komen niet overeen";
    }

    // Check of wachtwoord te kort is
    if (strlen($wachtwoord_nieuw) < 5) {
        return "FHet wachtwoord moet minimaal uit vijf tekens bestaan.";
    }

    // Als alles klopt, query uitvoeren om in de database te plaatsen.
    if ($ondernemer_of_klant == 'klant'){
        Update_klant_WW_with_Gebrnaam($wachtwoord_nieuw, $gebruikerdata->gebr_naam);
    }
    if ($ondernemer_of_klant == 'ondernemer'){
        Update_ondernemer_ww_with_Gebrnaam($wachtwoord_nieuw, $gebruikerdata->gebr_naam);
    }
    return "GU heeft uw wachtwoord aangepast!";

}

function UpdateTelnr ($nieuwetelnr, $gebruikersnaam, $ondernemer_of_klant){

    // Check of er een ongeldig Telefoonnummer ingevuld is
    if (!preg_match('/^[0-9]{10}+$/', $nieuwetelnr)) {
        return "FVul een geldig telefoonnummer in (bijvoorbeeld: 0612345678).";
    }

    // Check of het telefoonnummer dat is ingevult al een keer voorkomt in de database
    if (Get_klant_with_Telnr($nieuwetelnr) != null) {
        return "FDit telefoonnummer is al bekend in ons systeem.";
    }

    // Update telefoonnummer in de database
    if ($ondernemer_of_klant == 'klant'){
        Update_klant_telnr_with_Gebrnaam($nieuwetelnr, $gebruikersnaam);
    }
    if ($ondernemer_of_klant == 'ondernemer'){
        Update_ondernemer_telnr_with_Gebrnaam($nieuwetelnr, $gebruikersnaam);
    }
    return "GU heeft uw telefoonnummer aangepast!";


}

function UpdateEmail ($nieuwe_email, $gebruikersnaam, $ondernemer_of_klant){

    // Check of er een ongeldig email adres ingevuld is
    if (!filter_var($nieuwe_email, FILTER_VALIDATE_EMAIL)) {
        return "FVul een geldig email adres in.";
    }

    // Check of email al voorkomt in de database
    if (Get_klant_with_email($nieuwe_email)!= null) {
        return"FDit email adres is al bekend in ons systeem.";
    }

    // Update email in de database
    if ($ondernemer_of_klant == 'klant'){
        Update_klant_email_with_Gebrnaam($nieuwe_email, $gebruikersnaam);
    }
    if ($ondernemer_of_klant == 'ondernemer'){
        Update_ondernemer_email_with_Gebrnaam($nieuwe_email, $gebruikersnaam);
    }
    return "GU heeft uw email aangepast!";
}

?>
