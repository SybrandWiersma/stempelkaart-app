<?php
include("config.php");
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
        <a href=""><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
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