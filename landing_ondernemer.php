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
        <h1><a href="landing_ondernemer.php">StempelkaartApp</a></h1> 
        <a href=""><i class="fas fa-user-circle"></i>Profiel</a>
        <a href="landing_ondernemer.php?x=uitloggen"><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
    </div>
<?php
 }
 ?>
</nav>
<div class="wrapper">
    <h1>Ondernemerspagina</h1>
    <form action="">
       <input type="button" onclick="location.href='Ondernemer_qrscanner.php';" value="QR Scanner">
       <input type="button" onclick="location.href='huisstijl.php';" value="Huisstijl aanpassen">
       <input type="button" onclick="location.href='kaart_aanmaken.php';" value="Kaart aanmaken">
       <input type="button" onclick="location.href='ondernemer_kaartoverzicht.php';" value="Kaarten weergeven">
       <input type="button" onclick="location.href='ondernemer_gegevens.php';" value="Gegevens bekijken/wijzigen">
       <input type="button" onclick="location.href='landing_ondernemer.php?x=uitloggen';" value="Uitloggen">
    </div>
       </form>

        
        
        



</div>
</body>
</html>