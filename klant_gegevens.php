<?php
include("config.php");
require("header_klant.php");

$error_message = "";
$success_message = "";
$ww_message = "";

//query om klant gegevens uit de database op te halen
$sql_id = "SELECT  * FROM `klanten` WHERE `gebr_naam`='" . $_SESSION['klant'] . "'";
$sql_query_id = mysqli_query($con, $sql_id);
$result_id = mysqli_fetch_object($sql_query_id);

if (isset($_POST['ww'])) {
    $wachtwoord_o = trim($_POST['wachtwoord_o']);
    $wachtwoord_n = trim($_POST['wachtwoord_n']);
    $wachtwoord_h = trim($_POST['wachtwoord_h']);

    $test = true;

    if ($wachtwoord_o == '' || $wachtwoord_n == '' || $wachtwoord_h == '') {
        $test = false;
        $ww_message = "Het is verplicht om alle velden in te vullen!";
    }

    // Check of oude wachtwoord klopt
    if ($test && ($wachtwoord_o != $result_id->wachtwoord)) {
        $test = false;
        $ww_message = "Uw oude wachtwoord klopt niet";
    }

    // Check of oude wachtwoord klopt
    if ($test && ($wachtwoord_o == $wachtwoord_n)) {
        $test = false;
        $ww_message = "Uw nieuwe wachtwoord mag niet hetzelfde zijn als uw oude wachtwoord";
    }

    // Check of de wachtwoorden exact hetzelfde zijn
    if ($test && ($wachtwoord_n != $wachtwoord_h)) {
        $test = false;
        $ww_message = "Nieuwe wachtwoorden komen niet overeen";
    }

    // Check of wachtwoord te kort is
    if ($test && strlen($wachtwoord_n) < 5) {
        $test = false;
        $ww_message = "Het wachtwoord moet minimaal uit vijf tekens bestaan.";
    }

    // Als alles klopt, query uitvoeren om in de database te plaatsen.
    if ($test) {
        $insertSQL = "UPDATE `klanten` SET `wachtwoord`='" . $wachtwoord_n . "' WHERE `gebr_naam`='" . $_SESSION['klant'] . "'";
        $stmt = $con->prepare($insertSQL);
        $stmt->execute();
        $stmt->close();

        $wws_message = "U heeft uw wachtwoord aangepast!</br>";
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

        // Check of telefoonnummer al voorkomt in de database
        $stmt = $con->prepare("SELECT * FROM klanten WHERE tel_nr = ?");
        $stmt->bind_param("s", $telefoonnummer);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($telefoonnummer != $result_id->tel_nr && $result->num_rows > 0) {
            $klopt = false;
            $error_message = "Dit telefoonnummer is al bekend in ons systeem.</br>";
        }

    }


    if ($klopt) {

        // Check of email al voorkomt in de database
        $stmt = $con->prepare("SELECT * FROM klanten WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($email != $result_id->email && $result->num_rows > 0) {
            $klopt = false;
            $error_message = "Dit email adres is al bekend in ons systeem.</br>";
        }

    }


    // Als alles klopt, query uitvoeren om in de database te plaatsen.
    if ($klopt) {
        $insertSQL = "UPDATE `klanten` SET `email`='" . $email . "', `tel_nr`='" . $telefoonnummer . "' WHERE `gebr_naam`='" . $_SESSION['klant'] . "'";
        $stmt = $con->prepare($insertSQL);
        $stmt->execute();
        $stmt->close();

        $success_message = "Uw account is aangepast!</br>";
    }
}
?>

<div class="wrapper">
    <h1>Gegevens bekijken/aanpassen</h1>
    <form action="" method="post">
        <?php
        // Foutmelding
        if (!empty($ww_message)) {
            ?>

            <strong>Fout! </strong> <?= $ww_message ?>


            <?php
        }
        ?>

        <?php
        // Aanmaken gelukt
        if (!empty($wws_message)) {
            ?>

            <strong>Gelukt!</strong> <?= $wws_message ?>


            <?php
        }
        ?>
        <?php
        // Foutmelding
        if (!empty($error_message)) {
            ?>

            <strong>Fout! </strong> <?= $error_message ?>


            <?php
        }
        ?>

        <?php
        // Aanmaken gelukt
        if (!empty($success_message)) {
            ?>

            <strong>Gelukt!</strong> <?= $success_message ?>


            <?php
        }
        ?>
        <p><label for="gebruikersnaam">Gebruikersnaam:</label><br><input type="text" name="gebruikersnaam"
                                                                         id="gebruikersnaam"
                                                                         placeholder="<?php print $result_id->gebr_naam; ?>"
                                                                         readonly> <br>

            <label for="email">E-mailadres:</label><br><input type="email" name="email" id="email"
                                                              value="<?php print $result_id->email; ?>" required> <br>
            <label for="telefoonnummer">Telefoonnummer:</label><br><input type="text" name="telefoonnummer"
                                                                          id="telefoonnummer"
                                                                          value="<?php print $result_id->tel_nr; ?>"
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
