<?php
include("config.php");

// Uitloggen
if (isset($_GET['x'])) {
    if ($_GET['x'] == "uitloggen") {
        session_destroy();
        header('Location: index.php');
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Een digitaal welkom</title>
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

            <a href="loginpagina.php"><i class="fas fa-sign-out-alt"></i>Inloggen</a>
        </div>
        <?php
    } else {
        ?>
        <div>
            <h1><a href="">StempelkaartApp</a></h1>
            <a href=""><i class="fas fa-user-circle"></i>Profiel</a>
            <a href="index.php?x=uitloggen"><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
        </div>
        <?php
    }
    ?>
</nav>
<div class="wrapper">
    <h1>Welkom!</h1>


</div>
</body>
</html>