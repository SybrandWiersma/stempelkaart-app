<?php
include("config.php")

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
<div class="wrapperQRinfo">
        <h1>QR-Code Informatie</h1>
        <h4>Naam</h4> <p>Jelmer de Jong</p>
        <h4>Aantal stempels</h4> <p>4 / 12</p>
        <h4>Stempels Toevoegen</h4> <input type="number" min="1" max="12"> <!--max moet resterend aantal stempels zijn!-->
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
</div>

</body>
</html>