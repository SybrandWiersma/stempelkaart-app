<?php
include("config.php");
require("headers/header_ondernemer_reg.php");

$error_message = "";
$success_message = "";

// Na registreren
if (isset($_POST['registreer_o'])) {

    $gebr_naam = trim($_POST['gebruikersnaam']);
    $wachtwoord = trim($_POST['wachtwoord']);
    $wachtwoord_h = trim($_POST['wachtwoord_h']);
    $bedrijfsnaam = trim($_POST['bedrijfsnaam']);
    $email = trim($_POST['email']);
    $telefoonnummer = trim($_POST['telefoonnummer']);
    $kvk = trim($_POST['kvknummer']);

    $stemp = "images/default.jpg";

    //wachtwoord encoding werkt nog niet helemaal
    //$hash = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT, ['cost' => 12]);

    $klopt = true;

    // Check of alle velden ingevuld zijn
    if ($gebr_naam == '' || $wachtwoord == '' || $wachtwoord_h == '' || $bedrijfsnaam == '' || $email == '' || $telefoonnummer == '' || $kvk == '') {
        $klopt = false;
        $error_message = "Het is verplicht om alle velden in te vullen!";
    }

    // Check of de wachtwoorden exact hetzelfde zijn
    if ($klopt && ($wachtwoord != $wachtwoord_h)) {
        $klopt = false;
        $error_message = "Wachtwoorden komen niet overeen";
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

    // Check of wachtwoord te kort is
    if ($klopt && strlen($wachtwoord) < 5) {
        $klopt = false;
        $error_message = "Het wachtwoord moet minimaal uit vijf  tekens bestaan.";
    }


    if ($klopt) {

        // Check of telefoonnummer al voorkomt in de database
        $stmt = $con->prepare("SELECT * FROM ondernemers WHERE tel_nr = ?");
        $stmt->bind_param("s", $telefoonnummer);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $klopt = false;
            $error_message = "Dit telefoonnummer is al bekend in ons systeem.</br>";
        }

    }

    if ($klopt) {

        // Check of kvk al voorkomt in de database
        $stmt = $con->prepare("SELECT * FROM ondernemers WHERE kvk = ?");
        $stmt->bind_param("s", $kvk);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $klopt = false;
            $error_message = "Dit KvK-nummer is al bekend in ons systeem.</br>";
        }

    }
    if ($klopt) {

        // Check of email al voorkomt in de database
        $stmt = $con->prepare("SELECT * FROM ondernemers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $klopt = false;
            $error_message = "Dit email adres is al bekend in ons systeem.</br>";
        }

    }

    if ($klopt) {

        // Check of gebruikersnaam al voorkomt in de database (ondernemers)
        $stmt = $con->prepare("SELECT * FROM ondernemers WHERE gebr_naam = ?");
        $stmt->bind_param("s", $gebr_naam);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $klopt = false;
            $error_message = "Deze gebruikersnaam is al bekend in ons systeem.";
        }

    }

    if ($klopt) {

        // Check of gebruikersnaam al voorkomt in de database (klanten)
        $stmt = $con->prepare("SELECT * FROM klanten WHERE gebr_naam = ?");
        $stmt->bind_param("s", $gebr_naam);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $klopt = false;
            $error_message = "Deze gebruikersnaam is al bekend in ons systeem.";
        }

    }

    // Als alles klopt, query uitvoeren om in de database te plaatsen.
    if ($klopt) {
        $insertSQL = "INSERT INTO `ondernemers`(`bedrijfsnaam_ond`, `gebr_naam`, `wachtwoord`, `email`, `tel_nr`,`stemp_afb`,`kvk`) VALUES (?,?,?,?,?,?,?)";
        $stmt = $con->prepare($insertSQL);
        $stmt->bind_param("sssssss", $bedrijfsnaam, $gebr_naam, $wachtwoord, $email, $telefoonnummer, $stemp, $kvk);
        $stmt->execute();
        $stmt->close();

        $success_message = "Uw account is aangemaakt!</br>";
    }
}
?>

<div class="wrapper">
    <h1>Registreren</h1>
    <form action="" method="post">
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
        <input type="text" name="gebruikersnaam" id="gebruikersnaam" placeholder="Gebruikersnaam" required> <br>
        <input type="password" name="wachtwoord" id="wachtwoord" placeholder="Wachtwoord" required> <br>
        <input type="password" name="wachtwoord_h" id="wachtwoord_h" placeholder="Herhaal wachtwoord" required> <br>
        <input type="text" name="bedrijfsnaam" id="bedrijfsnaam" placeholder="Bedrijfsnaam" required> <br>
        <input type="text" name="kvknummer" id="kvknummer" placeholder="KvK-Nummer" required> <br>
        <input type="email" name="email" id="email" placeholder=" E-mail" required> <br>
        <input type="text" name="telefoonnummer" id="telefoonnummer" maxlength="10" placeholder="Telefoonnummer"
               required> <br>
        <input type="submit" name="registreer_o" value="Registreren">
        <button onclick="Terug()" id="btn_under"><i class="fas fa-chevron-left"></i> Terug</button>
        <br>
        <script>
            function Terug() {
                window.history.back();
            }
        </script>
        &nbsp;
    </form>
</div>

</body>
</html>
