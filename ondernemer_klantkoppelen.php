<?php
include("config.php");

// Check of gebruiker ingelogd is of niet
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: index.php');
}
// Uitloggen (eerste check of er een 'x' in de browser meegegeven wordt, zoja als dat uitloggen is word je uitgelogd)
if (isset($_GET['x'])) {
    if ($_GET['x'] == "uitloggen") {
        session_destroy();
        header('Location: index.php');
    }
}
// require __DIR__ . '/twilio-php-master/src/Twilio/autoload.php';
// use Twilio\Rest\Client;

//om fraude te voorkomen eerst een check of er een p en een o meegegeven worden
if (!isset($_GET['k']) && !isset($_GET['o'])) {
    header('Location: 404.php');
} else {

    //query om ondernemers_id uit de database op te halen
    $sql_id = "SELECT  `ondernemer_id` FROM `ondernemers` WHERE `gebr_naam`='" . $_SESSION['gebruikersnaam'] . "'";
    $sql_query_id = mysqli_query($con, $sql_id);
    $result_id = mysqli_fetch_object($sql_query_id);

    //query om gegevens stempelkaart uit de database op te halen
    $sql_stemp = "SELECT  * FROM `stempelkaarten` WHERE `stempelkaart_id`='" . $_GET['k'] . "'";
    $sql_query_stemp = mysqli_query($con, $sql_stemp);
    $result_stemp = mysqli_fetch_object($sql_query_stemp);

    //als de meegegeven o niet overeenkomt met het ondernemers id van de ingelogde persoon kom je op 404
    if ($_GET['o'] != $result_id->ondernemer_id) {
        header('Location: 404.php');
    } else {


        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Klant koppelen</title>
            <link rel="stylesheet" href="style.css" type="text/css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">


        </head>
        <body class="ondernemer_klantkoppelen">
        <nav class="navtop">
            <?php
            //check of gebruiker niet ingelogd is, dan weergeef je de registratie links en inlog link
            if (!isset($_SESSION['gebruikersnaam'])) {

                ?>

                <div>
                    <h1><a href="index.php">StempelkaartApp</a></h1>
                    <a href="ondernemer_registeren.php"><i class="fas fa-user-circle"></i>Registreren als ondernemer</a>
                    <a href="klant_registratie.php"><i class="fas fa-user-circle"></i>Registreren als klant</a>
                    <a href="loginpagina.php"><i class="fas fa-sign-out-alt"></i>Inloggen</a>
                </div>
                <?php
                //wanneer gebruiker wel ingelogd is weergeef je de links naar profiel en uitlog knop
            } else {
                ?>
                <div>
                    <h1><a href="ondernemer_landing.php">StempelkaartApp</a></h1>
                    <a href="ondernemer_gegevensbekijken.php"><i class="fas fa-user-circle"></i>Profiel</a>
                    <a href="ondernemer_landing.php?x=uitloggen"><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
                </div>
                <?php
            }
            ?>
        </nav>
        <div class="wrapper" style="overflow-x:auto;">

            <h1>Klant koppelen</h1>
            <?php


            if (!isset($_POST['koppel']) && !isset($_POST['koppelen1']) && !isset($_POST['koppelen2'])) {
                ?>
                <form action="" method="post">
                    <label for="telefoonnummer">Vul hier het telefoonnummer van de klant in:</label> <br>
                    <input type="number" name="telefoonnummer" maxlength="10" id="telefoonnummer"
                           placeholder="Telefoonnummer" required> <br>
                    <input type="submit" style="background-color: #5cb85c" name="koppel" value="Koppelen!">
                </form>
                <?php
            }

            if (isset($_POST['koppel'])) {
                $telefoonnummer = trim($_POST['telefoonnummer']);

                // Check of het veld ingevuld is
                if ($telefoonnummer == '') {
                    echo "<button style='padding: 20px;background-color: #f44336;color: white;cursor: help'>
            <strong>Het is verplicht om een telefoonnummer in te vullen!</strong></button>\"";
                }

                // Check of er een ongeldig Telefoonnummer ingevuld is
                if (!preg_match('/^[0-9]{10}+$/', $telefoonnummer)) {

                    echo "<button style='padding: 20px;background-color: #f44336;color: white;cursor: help'>
            <strong>Vul een geldig telefoonnummer in (bijvoorbeeld: 0612345678).</strong></button>";
                }

                $stmt = $con->prepare("SELECT * FROM klanten WHERE tel_nr = ?");
                $stmt->bind_param("s", $telefoonnummer);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                if ($result->num_rows > 0) {

                    //query om gegevens klant uit de database op te halen
                    $sql_klant = "SELECT  * FROM `klanten` WHERE `tel_nr`='" . $telefoonnummer . "'";
                    $sql_query_klant = mysqli_query($con, $sql_klant);
                    $result_klant = mysqli_fetch_object($sql_query_klant);


                    ?>

                    <form action="" method="post">

                        <label for="naam">Telefoonnummer van de klant:</label> <br>
                        <input type="text" style="margin-top: 3.5%; margin-bottom: 7%;" name="telefoonnummer"
                               id="telefoonnummer" value="<?php print $telefoonnummer; ?>" readonly> <br>
                        <label for="naam">Controleer de naam van de klant:</label> <br>
                        <input type="text" style="margin-top: 3.5%;margin-bottom: 7%;" name="naam" id="naam"
                               value="<?php print $result_klant->naam_klant; ?>" readonly> <br>
                        <label for="email">Controleer het E-mailadres van de klant:</label> <br>
                        <input type="text" style="margin-top: 3.5%; margin-bottom: 7%;" name="email" id="email"
                               value="<?php print $result_klant->email; ?>" readonly> <br>
                        <label for="stemps">Stempel(s) zetten (1-<?php print $result_stemp->beloning_aantstemps; ?>
                            ):</label><br><input style="margin-top: 3.5%; margin-bottom: 7%;" type="number"
                                                 name="stemps" id="stemps" min="1"
                                                 max="<?php print $result_stemp->beloning_aantstemps; ?>" value="1"
                                                 required>
                        <input type="submit" name="koppelen2" value="Koppelen!">

                    </form>
                    <?php
                } else {
                    ?>
                    <form action="" method="post">


                        <label for="naam" style="margin-top: 3.5%">Telefoonnummer van de klant:</label> <br>
                        <input type="number" style="margin-top: 3.5%; margin-bottom: 7%;" name="telefoonnummer"
                               id="telefoonnummer" value="<?php print $telefoonnummer; ?>" readonly> <br>
                        <label for="naam">Vul hier de naam van de klant in:</label> <br>
                        <input type="text" style="margin-top: 3.5%; margin-bottom: 7%;" name="naam" id="naam"
                               placeholder="Naam van de klant" required> <br>
                        <label for="email">Vul hier het E-mailadres van de klant in:</label> <br>
                        <input type="text" style="margin-top: 3.5%; margin-bottom: 7%;" name="email" id="email"
                               placeholder="E-mailadres van de klant" required> <br>
                        <label for="stemps">Stempel(s) zetten (1-<?php print $result_stemp->beloning_aantstemps; ?>
                            ):</label><br><input type="number" style="margin-top: 3.5%; margin-bottom: 7%;"
                                                 name="stemps" id="stemps" min="1"
                                                 max="<?php print $result_stemp->beloning_aantstemps; ?>" value="1"
                                                 required>
                        <input type="submit" style="background-color: #5cb85c" name="koppelen1" value="Koppelen!">
                    </form>

                    <?php
                }
            }
            if (isset($_POST['koppelen1'])) {
                $telefoonnummer = trim($_POST['telefoonnummer']);
                $naam = trim($_POST['naam']);
                $email = trim($_POST['email']);
                $stemps = trim($_POST['stemps']);
                $wachtwoord = "12345";

                // Check of alle velden ingevuld zijn
                if ($naam == '' || $email == '') {

                    echo "<button style='padding: 20px;background-color: #f44336;color: white;cursor: help'>
            <strong>Het is verplicht om alle velden in te vullen!</strong></button>\"";
                } else {

                    //acount aanmaken voor klant
                    $insertSQL = "INSERT INTO `klanten`(`naam_klant`, `wachtwoord`, `email`, `tel_nr`) VALUES (?,?,?,?)";
                    $stmt = $con->prepare($insertSQL);
                    $stmt->bind_param("ssss", $naam, $wachtwoord, $email, $telefoonnummer);
                    $stmt->execute();
                    $stmt->close();

                    $sql_klant = "SELECT  * FROM `klanten` WHERE `tel_nr`='" . $telefoonnummer . "'";
                    $sql_query_klant = mysqli_query($con, $sql_klant);
                    $result_klant = mysqli_fetch_object($sql_query_klant);


                    //account gebonden kaart aanmaken voor klant
                    $insertSQLkaart = "INSERT INTO `stempelkaart_klant`(`klant_id`, `stempelkaart_id`,`aant_stemps`) VALUES (?,?,?)";
                    $stmtkaart = $con->prepare($insertSQLkaart);
                    $stmtkaart->bind_param("sss", $result_klant->klant_id, $result_stemp->stempelkaart_id, $stemps);
                    $stmtkaart->execute();
                    $stmtkaart->close();

                    // Your Account SID and Auth Token from twilio.com/console
                    //$account_sid = 'AC130becb9d447719ce8a66fe05b69b396';
                    //$auth_token = '007f7767c94f548993dc8ff4a2bc522f';


                    //query om ondernemers_id uit de database op te halen
                    //$sql_id = "SELECT  * FROM `ondernemers` WHERE `gebr_naam`='".$_SESSION['gebruikersnaam']."'";
                    // $sql_query_id = mysqli_query($con,$sql_id);
                    //$result_id = mysqli_fetch_object($sql_query_id);

                    // $link = "http://127.0.0.1/loginpagina.php";

                    // $bericht =  "".$result_id->bedrijfsnaam_ond." heeft een stempelkaart voor u aangemaakt, log in om hem te kijken op uw persoonlijke profiel: ".$link."";
                    //$countryCode = 31;
                    //$newnumber = preg_replace('/^0?/', '+'.$countryCode, $telefoonnummer);
                    //$twilio_number = "+15868001420";
                    //$client = new Client($account_sid, $auth_token);
                    // $client->messages->create(
                    // Where to send a text message (your cell phone?)
                    // $newnumber,
                    // array(
                    //    'from' => $twilio_number,
                    //    'body' => $bericht
                    //)
//);


                    echo "<button style='padding: 20px;background-color: #5cb85c;color: white;cursor: help'>
            <strong>Er is een persoonlijk account aangemaakt voor uw klant en deze is automatisch gekoppeld aan uw stempelkaart!</strong></button>";

                }

            }

            if (isset($_POST['koppelen2'])) {
                $telefoonnummer = trim($_POST['telefoonnummer']);
                $naam = trim($_POST['naam']);
                $email = trim($_POST['email']);
                $stemps = trim($_POST['stemps']);
                $wachtwoord = "12345";

                $sql_klant = "SELECT  * FROM `klanten` WHERE `tel_nr`='" . $telefoonnummer . "'";
                $sql_query_klant = mysqli_query($con, $sql_klant);
                $result_klant = mysqli_fetch_object($sql_query_klant);

                $stmt = $con->prepare("SELECT * FROM stempelkaart_klant WHERE klant_id = ? AND stempelkaart_id = ?");
                $stmt->bind_param("ss", $result_klant->klant_id, $result_stemp->stempelkaart_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                if ($result->num_rows > 0) {
                    echo "<button style='padding: 20px;background-color: #f44336;color: white;cursor: help'>
            <strong>Deze stempelkaart heeft al een koppeling met de klant!</strong></button>";
                } else {

                    //account gebonden kaart aanmaken voor klant
                    $insertSQLkaart = "INSERT INTO `stempelkaart_klant`(`klant_id`, `stempelkaart_id`, `aant_stemps`) VALUES (?,?,?)";
                    $stmtkaart = $con->prepare($insertSQLkaart);
                    $stmtkaart->bind_param("sss", $result_klant->klant_id, $result_stemp->stempelkaart_id, $stemps);
                    $stmtkaart->execute();
                    $stmtkaart->close();

                    // Your Account SID and Auth Token from twilio.com/console
                    //$account_sid = 'AC130becb9d447719ce8a66fe05b69b396';
                    // $auth_token = '5883a1bdd6f0ab7d28733bd6ee576cd5';
                    // In production, these should be environment variables. E.g.:
                    // $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]
                    // A Twilio number you own with SMS capabilities

                    //query om ondernemers_id uit de database op te halen
                    //$sql_id = "SELECT  * FROM `ondernemers` WHERE `gebr_naam`='".$_SESSION['gebruikersnaam']."'";
                    // $sql_query_id = mysqli_query($con,$sql_id);
                    // $result_id = mysqli_fetch_object($sql_query_id);

                    //$link = "http://127.0.0.1/loginpagina.php";

                    // $bericht =  "".$result_id->bedrijfsnaam_ond." heeft u gekoppeld aan een stempelkaart, log in om hem te kijken op uw persoonlijke profiel: ".$link."";
                    // $countryCode = 31;
                    // $newnumber = preg_replace('/^0?/', '+'.$countryCode, $telefoonnummer);
                    //$twilio_number = "+15868001420";
                    //$client = new Client($account_sid, $auth_token);
                    //$client->messages->create(
                    // Where to send a text message (your cell phone?)
                    // $newnumber,
                    // array(
                    //     'from' => $twilio_number,
                    //    'body' => $bericht
                    // )
//);
                    echo "<button style='padding: 20px;background-color: #5cb85c;color: white;cursor: help'>
            <strong>Uw klant is gekoppeld aan de stempelkaart!</strong></button>";
                }
            }
            ?>

            <center>
                <button onclick="location.href='ondernemer_kaartoverzicht.php';" id="btn_under"><i
                            class="fas fa-chevron-left"></i> Terug
                </button>
            </center>

            <h1></h1>
        </div>


        </div>
        </body>
        </html>

        <?php
    }
}
?>