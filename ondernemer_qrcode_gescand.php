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

$query_ondernemingID = "SELECT ondernemer_id FROM ondernemers WHERE gebr_naam = '".$_SESSION['gebruikersnaam']."';";
$result_ondernemingID = mysqli_query($con, $query_ondernemingID);
$row_ondernemingID = mysqli_fetch_array($result_ondernemingID);

$ondernemer_id = $row_ondernemingID['ondernemer_id'];
$klant_id = $_GET['klantid'];
$kaart_id = $_GET['kaartid'];

if(!isset($klant_id) && !isset($kaart_id)){
    header('Location: 404.php');
}
$query_check_koppeling = "SELECT * FROM stempelkaarten WHERE ondernemer_id ='".$ondernemer_id."' AND stempelkaart_id ='".$kaart_id."';";
$result_check_koppeling = mysqli_query($con, $query_check_koppeling);
if(mysqli_num_rows($result_check_koppeling) == 0){
    header('Location: 404.php');
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR-code Informatie</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<nav class="navtop">
    <?php
    //check of gebruiker niet ingelogd is, dan weergeef je de registratie links en inlog link
    if(!isset($_SESSION['gebruikersnaam'])){

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
<div class="wrapperQRinfo">
    <form action="ondernemer_qrcode_gescand.php?kaartid=<?echo$kaart_id?>&klantid=<?echo$klant_id?>">
        <h1>QR-Code Informati</h1>
        <h4>Naam</h4> <p><?echo$klant_naam?></p>
        <h4>Aantal stempels</h4> <p>4 / 12</p>
        <h4>Stempels Toevoegen</h4> <input type="number" value="1" min="1" max="12"> <!--max moet resterend aantal stempels zijn!-->
        <div style="border-bottom: 1px solid #dee0e4"></div>
    <button>Stempel(s) Zetten</button>
    <button>Kaart Verzilveren</button>
    <button onclick="window.location.href'#'">Kaart Wijzigen</button>
    <button style="background-color: red; margin-bottom: 5%">Kaart Verwijderen</button>
    <div style="border-bottom: 1px solid #dee0e4"></div>
    <button onclick="goBack()" style="width: 40%; margin-bottom: 5%"><i class="fas fa-chevron-left"></i> Terug</button> <br>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    </form>
</div>

</body>
</html>