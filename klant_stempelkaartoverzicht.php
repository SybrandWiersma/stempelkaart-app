<?php
include("config.php");

// Check of gebruiker ingelogd is of niet
if(!isset($_SESSION['gebruikersnaam'])){
    header('Location: index.php');
}
// Uitloggen (eerste check of er een 'x' in de browser meegegeven wordt, zoja als dat uitloggen is word je uitgelogd)
if(isset($_GET['x'])){
    if($_GET['x'] == "uitloggen"){
    session_destroy();
    header('Location: index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stempelkaart informatie</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<nav class="navtop">
<?php
if(!isset($_SESSION['gebruikersnaam'])){

?>

    <div>
       <h1><a href="index.php">StempelkaartApp</a></h1>
        <a href="ond_registratie.php"><i class="fas fa-user-circle"></i>Registreren als ondernemer</a>
        <a href="klant_registratie.php"><i class="fas fa-user-circle"></i>Registreren als klant</a>
        <a href="loginpage.php"><i class="fas fa-sign-out-alt"></i>Inloggen</a>
    </div>
<?php
} else {
?>
    <div>
        <h1><a href="">StempelkaartApp</a></h1> 
        <a href=""><i class="fas fa-user-circle"></i>Profiel</a>
        <a href="landing_ondernemer.php?x=uitloggen"><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
    </div>
<?php
 }
 ?>
</nav>
<div class="wrapperStempelkaartOverzicht">
    <h1>Uw Stempelkaarten</h1>
    <div class="StempelkaartOverzicht_div">
        <ul style="list-style-type:none;">
            <li class="Stempelkaart">
                <div id="ond_naam">
                    <h2>Snackbar Vette Hap</h2>
                </div>
                <div id="aant_stemp">
                    <h2> 3/8</h2>
                </div>
            </li>
            <li class="Stempelkaart">
                <div id="ond_naam">
                    <h2>Kapper Knipschaar</h2>
                </div>
                <div id="aant_stemp">
                    <h2> 4/12</h2>
                </div>
            </li>
            <li class="Stempelkaart">
                <div id="ond_naam">
                    <h2>Schoonheidssalon Marije</h2>
                </div>
                <div id="aant_stemp">
                    <h2> 1/6</h2>
                </div>
            </li>
        </ul>
    </div>
    <div style="border-bottom: 1px solid #dee0e4"></div>
    <button onclick="window.location.href='#'">Voeg een stempelkaart toe</button>
    <button onclick="goBack()" style="width: 40%; margin-bottom: 5%"><i class="fas fa-chevron-left"></i> Terug</button> <br>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</div>