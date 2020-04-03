<?php
include("config.php")
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Klant Registratie</title>
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
<div class="wrapper">
    <h1>Registreren</h1>
    <form action="" method="post">
        <input type="text" name="gebruikersnaam" id="gebruibersnaam" placeholder="Gebruikersnaam" required> <br>
        <input type="password" name="wachtwoord" id="wachtwoord" placeholder="Wachtwoord" required> <br>
        <input type="text" name="voornaam" id="voornaam" placeholder="Voornaam" required> <br>
        <input type="text" name="achternaam" id="achternaam" placeholder="Achternaam" required> <br>
        <input type="email" name="email" id="email" placeholder="E-mail" required> <br>
        <input type="text" name="telefoonnummer" id="telefoonnummer" placeholder="Telefoonnummer" required> <br>
        <input type="submit" value="Registreren">
        <button onclick="goBack()" id="btn_under"><i class="fas fa-chevron-left"></i> Terug</button>
<!--        Doet nog niks omdat er nog geen navigatie is-->
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
<!--        Doet nog niks omdat er nog geen navigatie is-->

    </form>
</div>

</body>
</html>