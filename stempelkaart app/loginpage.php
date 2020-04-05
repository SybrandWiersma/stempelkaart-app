<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loginpage</title>
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
<div class="login">
    <h1>Login</h1>
    <form action="" method="post">
        <label for="gebruikersnaam">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="gebruikersnaam" id="gebruikersnaam" placeholder="Gebruikersnaam" required> <br>
        <label for="Wachtwoord">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="wachtwoord" id="wachtwoord" placeholder="Wachtwoord" required> <br>
        <input type="submit" value="Inloggen">
    </form>
</div>
</body>
</html>