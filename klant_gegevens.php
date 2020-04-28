<?php
include("config.php");
require("header_klant.php");


//query om klant gegevens uit de database op te halen

$klantdata = Get_klant_with_Gebrnaam($_SESSION['klant']);



if (isset($_POST['ww'])) {
    $wachtwoord_o = trim($_POST['wachtwoord_o']);
    $wachtwoord_n = trim($_POST['wachtwoord_n']);
    $wachtwoord_h = trim($_POST['wachtwoord_h']);


    $test = true;

    if ($wachtwoord_o == '' || $wachtwoord_n == '' || $wachtwoord_h == '') {
        $test = false;
        $error_message = "Het is verplicht om alle velden in te vullen!";
    }

    // Check of oude wachtwoord klopt
    if ($test && ($wachtwoord_o != $klantdata->wachtwoord)) {
        $test = false;
        $error_message = "Uw oude wachtwoord klopt niet";
    }

    // Check of oude wachtwoord klopt
    if ($test && ($wachtwoord_o == $wachtwoord_n)) {
        $test = false;
        $error_message = "Uw nieuwe wachtwoord mag niet hetzelfde zijn als uw oude wachtwoord";
    }

    // Check of de wachtwoorden exact hetzelfde zijn
    if ($test && ($wachtwoord_n != $wachtwoord_h)) {
        $test = false;
        $error_message = "Nieuwe wachtwoorden komen niet overeen";
    }

    // Check of wachtwoord te kort is
    if ($test && strlen($wachtwoord_n) < 5) {
        $test = false;
        $error_message = "Het wachtwoord moet minimaal uit vijf tekens bestaan.";
    }

    // Als alles klopt, query uitvoeren om in de database te plaatsen.
    if ($test) {
        Update_klant_WW_with_Gebrnaam($wachtwoord_n, $_SESSION['klant']);

        $succes_message = "U heeft uw wachtwoord aangepast!";
    }
}


// Na registreren
if (isset($_POST['aanpassen'])) {

    $gebr_naam = trim($_POST['gebruikersnaam']);

    $email = trim($_POST['email']);
    $telefoonnummer = trim($_POST['telefoonnummer']);


    //wachtwoord encoding werkt nog niet helemaal
    //$hash = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT, ['cost' => 12]);

    $klopt = true;

    // Check of alle velden ingevuld zijn
    if ($gebr_naam == '' || $email == '' || $telefoonnummer == '') {
        $klopt = false;
        $error_message = "Het is verplicht om alle velden in te vullen!";
    }


    // Check of er een ongeldig email adres ingevuld is
    if ($klopt && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $klopt = false;
        $error_message = "Vul een geldig email adres in.";
    }

    // Check of er een ongeldig Telefoonnummer ingevuld is
    if ($klopt && !preg_match('/^[0-9]{10}+$/', $telefoonnummer)) {
        $klopt = false;
        $error_message = "Vul een geldig telefoonnummer in (bijvoorbeeld: 0612345678).";
    }


    if ($klopt) {
        if ($telefoonnummer != $klantdata->tel_nr && Get_klant_with_Telnr($telefoonnummer)!= null) {
            $klopt = false;
            $error_message = "Dit telefoonnummer is al bekend in ons systeem.";
        }

    }


    if ($klopt) {
        // Check of email al voorkomt in de database
        if ($email != $klantdata->email && Get_klant_with_email($email)!= null) {
            $klopt = false;
            $error_message = "Dit email adres is al bekend in ons systeem.";
        }

    }


    // Als alles klopt, query uitvoeren om in de database te plaatsen.
    if ($klopt) {
        $insertSQL = "UPDATE klanten SET email = ?, tel_nr = ? WHERE gebr_naam = ?";
        $stmt = $con->prepare($insertSQL);
        $stmt->bind_param("sss", $emai, $telefoonnummer, $_SESSION['klant']);
        $stmt->execute();
        $stmt->close();
        $succes_message = "Uw account is aangepast!";
    }
}

if(isset($error_message)){
    $message = "<strong>Fout! </strong>".$error_message."</br>";
}
if(isset($succes_message)){
    $message = "<strong>Gelukt! </strong>".$succes_message."</br>";
}

?>



<div class="wrapper">
    <h1>Gegevens bekijken/aanpassen</h1>
    <form action="" method="post">
        <?php if (isset($message)) echo $message ?>

        <p><label for="gebruikersnaam">Gebruikersnaam:</label><br><input type="text" name="gebruikersnaam"
                                                                         id="gebruikersnaam"
                                                                         value="<?php echo $klantdata->gebr_naam ?>"
                                                                         > <br>

            <label for="email">E-mailadres:</label><br><input type="email" name="email" id="email"
                                                              value="<?php echo $klantdata->email; ?>" required> <br>
            <label for="telefoonnummer">Telefoonnummer:</label><br><input type="text" name="telefoonnummer"
                                                                          id="telefoonnummer"
                                                                          value="<?php print $klantdata->tel_nr ?>"
                                                                          required> <br>
            <input type="submit" name="aanpassen" value="Aanpassen!"></p>

    </form>
    <form action="" method="post">
        <label for="wachtwoord_o">Uw oude wachtwoord:</label><br><input type="password" name="wachtwoord_o"
                                                                        id="wachtwoord" placeholder="Oude wachtwoord"
                                                                        required> <br>
        <label for="wachtwoord_n">Nieuwe wachtwoord:</label><br><input type="password" name="wachtwoord_n"
                                                                       id="wachtwoord" placeholder="Nieuwe wachtwoord"
                                                                       required> <br>
        <label for="wachtwoord_h">Herhaal nieuwe wachtwoord:</label><br><input type="password" name="wachtwoord_h"
                                                                               id="wachtwoord_h"
                                                                               placeholder="Herhaal nieuwe wachtwoord"
                                                                               required> <br>


        <input type="submit" name="ww" value="Aanpassen!">
    </form>
    <button onclick="location.href='klant_stempelkaartoverzicht.php';" id="btn_under"><i
                class="fas fa-chevron-left"></i> Terug
    </button>

    <h1></h1>
</div>

</body>
</html>
