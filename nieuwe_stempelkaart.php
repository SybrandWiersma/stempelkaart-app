<?php
include("config.php")

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nieuwe Stempelkaart</title>
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
            <a href="ondernemer_registeren.php"><i class="fas fa-user-circle"></i>Registreren als ondernemer</a>
            <a href="klant_registratie.php"><i class="fas fa-user-circle"></i>Registreren als klant</a>
            <a href="loginpagina.php"><i class="fas fa-sign-out-alt"></i>Inloggen</a>
        </div>
        <?php
    } else {
        ?>
        <div>
            <h1><a href="">StempelkaartApp</a></h1>
            <a href=""><i class="fas fa-user-circle"></i>Profiel</a>
            <a href="ondernemer_landing.php?x=uitloggen"><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
        </div>
        <?php
    }
    ?>
</nav>
<div class="wrapper_newStempelkaart">
    <h1>Kaart Toevoegen</h1>
    <h2>Kaart code</h2>
    <input type="text" style="width: 60%"> <input type="submit" value="Zoeken" style="width: 20%; padding: 2.5%">
    <h2 style="margin: 0">Of</h2>
    <button onclick="window.location.href:'#'" style="width: 50%; margin-bottom: 4%">QR-code scannen</button>
    <div style="border-bottom: 1px solid #dee0e4"></div>
    <h2>Geselecteerd</h2>
    <div class="Stempelkaart" style="padding: 1%">
        <div style="text-align: center">
            <h4 style="color: black">Snackbar Vette Hap</h4>
        </div>
    </div>
    <div style="border-bottom: 1px solid #dee0e4"></div>
    <button onclick="window.location.href'#'">Kaart toevoegen</button>
    <button onclick="goBack()" style="width: 40%; margin-bottom: 5%"><i class="fas fa-chevron-left"></i> Terug</button> <br>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</div>