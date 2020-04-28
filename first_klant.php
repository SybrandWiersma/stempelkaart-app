<?php
include("config.php");
require("header_klant.php");

// Check of er fraude is in het bereiken van deze pagina
if (!isset($_GET['x'])) {
    header('Location: 404.php');
} else {

    //query om gegevens klant uit de database op te halen
    $sql_klant = "SELECT  * FROM `klanten` WHERE `klant_id`='" . $_GET['x'] . "'";
    $sql_query_klant = mysqli_query($con, $sql_klant);
    $result_klant = mysqli_fetch_object($sql_query_klant);

    //indien klant al een ander wachtwoord aangemaakt heeft, wordt deze automatisch doorgestuurd naar login pagina voor klanten
    if ($result_klant->wachtwoord != 12345) {
        header('Location: loginpagina.php?p=aangepast');

    } else {

        $ww_message = "";


        if (isset($_POST['ww'])) {
            $wachtwoord_o = 12345;
            $wachtwoord_n = trim($_POST['wachtwoord_n']);
            $wachtwoord_h = trim($_POST['wachtwoord_h']);
            $gebruikersnaam = trim($_POST['naam']);

            $test = true;

            if ($wachtwoord_n == '' || $wachtwoord_h == '') {
                $test = false;
                $ww_message = "Het is verplicht om alle velden in te vullen!";
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

            if ($test) {

                // Check of gebruikersnaam al voorkomt in de database (ondernemers)
                $stmt = $con->prepare("SELECT * FROM ondernemers WHERE gebr_naam = ?");
                $stmt->bind_param("s", $gebruikersnaam);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                if ($result->num_rows > 0) {
                    $test = false;
                    $ww_message = "Deze gebruikersnaam is al bekend in ons systeem.";
                }

            }

            if ($test) {

                // Check of gebruikersnaam al voorkomt in de database (klanten)
                $stmt = $con->prepare("SELECT * FROM klanten WHERE gebr_naam = ?");
                $stmt->bind_param("s", $gebruikersnaam);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                if ($result->num_rows > 0) {
                    $test = false;
                    $ww_message = "Deze gebruikersnaam is al bekend in ons systeem.";
                }

            }

            // Als alles klopt, query uitvoeren om in de database te plaatsen.
            if ($test) {
                $insertSQL = "UPDATE `klanten` SET `wachtwoord`='" . $wachtwoord_n . "', `gebr_naam`='" . $gebruikersnaam . "' WHERE `klant_id`='" . $_GET['x'] . "'";
                $stmt = $con->prepare($insertSQL);
                $stmt->execute();
                $stmt->close();

                header('Location: loginpagina.php?p=gelukt&x=' . $_GET['x']);

            }
        }


        ?>


        <div class="wrapper">
            <h1>Wachtwoord aanmaken</h1>
            <p><strong> De eerste keer dat u inlogt moet u een nieuw wachtwoord en gebruikersnaam aanmaken! </strong>
            </p>
            <form action="" method="post">

                <?php
                // Foutmelding
                if (!empty($ww_message))
                    echo "<strong>Fout! </strong>".$ww_message."<br>";
                ?>


                <form action="" method="post">
                    <label for="naam">Uw gebruikersnaam:</label><br><input type="text" name="naam" id="naam"
                                                                           placeholder="Gebruikersnaam" required> <br>
                    <label for="wachtwoord_n">Nieuwe wachtwoord:</label><br><input type="password" name="wachtwoord_n"
                                                                                   id="wachtwoord"
                                                                                   placeholder="Nieuwe wachtwoord"
                                                                                   required> <br>
                    <label for="wachtwoord_h">Herhaal nieuwe wachtwoord:</label><br><input type="password"
                                                                                           name="wachtwoord_h"
                                                                                           id="wachtwoord_h"
                                                                                           placeholder="Herhaal nieuwe wachtwoord"
                                                                                           required> <br>


                    <input type="submit" name="ww" value="Aanpassen!">
                </form>


                <h1></h1>
        </div>

        </body>
        </html>
