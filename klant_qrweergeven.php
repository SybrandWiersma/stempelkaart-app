<?php
include("config.php")

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR-code</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<nav class="navtop">
    <?php
    if (!isset($_SESSION['gebruikersnaam'])) {

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
<div class="wrapper">
    <h1>Snackbar Vette Hap</h1>
    <h2>QR-Code</h2>
    <div style="border: 2px solid #2f3034; margin: 4% 30% 4% 30%; padding: 4%; height: 120px">"hier qr code zonder
        border"
    </div>
    <button onclick="goBack()" style="width: 40%; margin-bottom: 5%; margin-left: 30%"><i
                class="fas fa-chevron-left"></i> Terug
    </button>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</div>