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
    <title>Ondernemerspagina</title>
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
<div class="wrapperStempelkaartInfo">
    <h1>Snackbar Vette Hap</h1>
    <h2 style="margin-left: -60%">Stempels: </h2>
    <div class="StempelsInfo">

    </div>
    <button onclick="window.location.href='qr-code.html'" style="width: 40%">QR-Code</button><br>
    <button onclick="window.location.href='beloning.html'" style="width: 40%">Beloning Bekijken</button><br>
    <button onclick="goBack()" style="width: 40%; margin-bottom: 5%"><i class="fas fa-chevron-left"></i> Terug naar Kaarten</button> <br>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
     <button style="width: 25%; background-color: red; margin-bottom: 5%">Verwijderen</button>
</div>
</body>
</html>