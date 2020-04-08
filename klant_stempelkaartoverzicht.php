<?php
include("config.php")

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stempelkaart Info</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<nav class="navtop">
    <div>
        <h1>StempelkaartApp</h1>
        <a href=""><i class="fas fa-user-circle"></i>Profiel</a>
        <a href=""><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
    </div>
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