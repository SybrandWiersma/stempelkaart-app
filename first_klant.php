<?php
include("config.php");
$title = "Wachtwoord Aanpassen";
include("functions/functions.php");
// Check of er fraude is in het bereiken van deze pagina
if (!isset($_GET['x'])) {
    header('Location: 404.php');
} else {

    $result_klant = Get_klant_with_ID($_GET['x']);


    //indien klant al een ander wachtwoord aangemaakt heeft, wordt deze automatisch doorgestuurd naar login pagina voor klanten
    if ($result_klant->wachtwoord != 12345) {
        header('Location: loginpagina.php?p=aangepast');

    } else {


        if (isset($_POST['ww'])) {
            $wachtwoord_o = 12345;
            $wachtwoord_n = trim($_POST['wachtwoord_n']);
            $wachtwoord_h = trim($_POST['wachtwoord_h']);
            $gebruikersnaam = trim($_POST['naam']);
            $goedgekeurd = true;
            $ww_message = "";

            //check of velden niet leeg zijn
            if ($wachtwoord_n == '' || $wachtwoord_h == '') {
                $goedgekeurd = false;
                $ww_message = "<strong>Fout! </strong> Het is verplicht om alle velden in te vullen!";

            }


            // Check of oude wachtwoord klopt
            if ($goedgekeurd && ($wachtwoord_o == $wachtwoord_n)) {
                $goedgekeurd = false;
                $ww_message = "<strong>Fout! </strong> Uw nieuwe wachtwoord mag niet hetzelfde zijn als uw oude wachtwoord";
            }

            // Check of de wachtwoorden exact hetzelfde zijn
            if ($goedgekeurd && ($wachtwoord_n != $wachtwoord_h)) {
                $goedgekeurd = false;
                $ww_message = "<strong>Fout! </strong> Nieuwe wachtwoorden komen niet overeen";
            }

            // Check of wachtwoord te kort is
            if ($goedgekeurd && strlen($wachtwoord_n) < 5) {
                $goedgekeurd = false;
                $ww_message = "<strong>Fout! </strong> Het wachtwoord moet minimaal uit vijf tekens bestaan.";
            }

            // Check of gebruikersnaam al voorkomt in de database (ondernemers)
            if ($goedgekeurd) {
                $result = Count_ondernemer_with_Gebrnaam($gebruikersnaam);
                if ($result > 0) {
                    $goedgekeurd = false;
                    $ww_message = "<strong>Fout! </strong> Deze gebruikersnaam is al bekend in ons systeem.";
                }

            }
            // Check of gebruikersnaam al voorkomt in de database (klanten)
            if ($goedgekeurd) {
                $result = Count_klant_with_Gebrnaam($gebruikersnaam);
                if ($result > 0) {
                    $goedgekeurd = false;
                    $ww_message = "<strong>Fout! </strong> Deze gebruikersnaam is al bekend in ons systeem.";
                }

            }

            // Als alles klopt, query uitvoeren om in de database te plaatsen.
            if ($goedgekeurd) {
                Update_klant_WW_Gebrnaam_with_klantID($wachtwoord_n, $gebruikersnaam, $_GET['x']);
                header('Location: loginpagina.php?p=gelukt&x=' . $_GET['x']);

            }
        }

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>StempelkaartApp</title>
            <link rel="stylesheet" href="style.css" type="text/css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        </head>
        <body>


        <div class="wrapper">
            <h1>Wachtwoord aanmaken</h1>
            <p><strong> De eerste keer dat u inlogt moet u een nieuw wachtwoord en gebruikersnaam aanmaken! </strong>
            </p>
            <form action="" method="post">

                <?php
                // Foutmelding
                if (!empty($ww_message)) {
                    echo $ww_message;
                }
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
        <?php
    }
}
?>
