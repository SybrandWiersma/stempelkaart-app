<?php
include("config.php");


if (isset($_GET['p'])) {
    if ($_GET['p'] == "aangepast") {
        $message = "U heeft uw automatische wachtwoord al aangepast, log in met uw gegevens";
    } else if ($_GET['p'] == "gelukt") {
        $message = "U heeft uw automatische wachtwoord aangepast, log in met uw gegevens";
    }
}

if (isset($_GET['x'])) {
    $klantdata = Get_klant_with_klantID($_GET['x']);

    if ($klantdata->wachtwoord == "12345") {
        header('Location:  first_klant.php?x=' . $_GET['x']);
    }
}

if (isset($_POST['send'])) {

    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];

    if ($gebruikersnaam != "" && $wachtwoord != "") {

        $klant = Get_klant_with_Gebrnaam_ww($gebruikersnaam, $wachtwoord);
        $ondernemer = Get_ondernemer_with_Gebrnaam_ww($gebruikersnaam, $wachtwoord);

        if ($ondernemer != null) {
            $_SESSION['gebruikersnaam'] = $ondernemer->gebr_naam;
            header('Location: ondernemer_landing.php');
        }

        if ($klant != null){

            if ($wachtwoord == "12345") {
                header('Location:  first_klant.php?x=' . $klant->klant_id);
            } else {
                $_SESSION['klant'] = $klant->gebr_naam;
                header('Location: klant_stempelkaartoverzicht.php');
            }
        }

        $message = "De combinatie van gebruikersnaam en wachtwoord kwamen niet overeen! </br></br>";
    }

}


require("header_index.php");
?>

<div class="wrapper">
    <h1>Login</h1>
    <form action="" method="post">
        <?php if (isset($message)) echo $message; ?>

        <label for="gebruikersnaam"><i class="fas fa-user"></i></label>
        <input type="text" name="gebruikersnaam" id="gebruikersnaam" placeholder="Gebruikersnaam" required> <br>

        <label for="wachtwoord"><i class="fas fa-lock"></i></label>
        <input type="password" name="wachtwoord" id="wachtwoord" placeholder="Wachtwoord" required> <br>

        <input type="submit" name="send" value="Inloggen">
        <button onclick="Terug()" id="btn_under"><i class="fas fa-chevron-left"></i> Terug</button>

    </form>
    <h1></h1>
</div>
<script>
    function Terug() {
        window.history.back();
    }
</script>
</body>
</html>