<?php
include("config.php");
include("functions/functions_gebruikergegevens.php");

//query om ondernemers gegevens uit de database op te halen
$ondernemerdata = Get_ondernemer_with_Gebrnaam($_SESSION['gebruikersnaam']);


if (isset($_POST['ww'])) {
    $message = UpdateWachtwoord($_POST['wachtwoord_o'], $_POST['wachtwoord_n'], $_POST['wachtwoord_h'], $ondernemerdata, 'ondernemer');
}


// Na registreren
if (isset($_POST['aanpassen'])) {

    if ($ondernemerdata->bedrijfsnaam_ond != $_POST['bedrijfsnaam']) {
        $messageBedrnaam = UpdateBedrNaam($_POST['bedrijfsnaam'], $ondernemerdata->gebr_naam, 'ondernemer');
        if ($messageBedrnaam[0] == 'G') $ondernemerdata->bedrijfsnaam_ond = $_POST['bedrijfsnaam'];
        $message .= CreateMessage($messageBedrnaam);
    }

    if ($ondernemerdata->email != $_POST['email']) {
        $messageEmail = UpdateEmail($_POST['email'], $ondernemerdata->gebr_naam, 'ondernemer');
        if ($messageEmail[0] == 'G') $ondernemerdata->email = $_POST['email'];
        $message .= CreateMessage($messageEmail);
    }

    if ($ondernemerdata->tel_nr != $_POST['telefoonnummer']) {
        $messageTelnr = UpdateTelnr($_POST['telefoonnummer'], $ondernemerdata->gebr_naam, 'ondernemer');
        if ($messageTelnr[0] == 'G') $ondernemerdata->tel_nr = $_POST['telefoonnummer'];
        $message .= CreateMessage($messageTelnr);
    }

    if ($ondernemerdata->kvk != $_POST['kvknummer']) {
        $messageKvk = UpdateKvk($_POST['kvknummer'], $ondernemerdata->gebr_naam, 'ondernemer');
        if ($messageKvk[0] == 'G') $ondernemerdata->kvk = $_POST['kvknummer'];
        $message .= CreateMessage($messageKvk);
    }
}

require("headers/header_ondernemer.php");
?>


<div class="wrapper">
    <h1>Gegevens bekijken/aanpassen</h1>
    <form action="" method="post">
        <?php if(isset($message)) echo $message ?>

        <label for="gebruikersnaam">Gebruikersnaam:</label><br>
        <input type="text" name="gebruikersnaam" id="gebruikersnaam" placeholder="<?php echo $ondernemerdata->gebr_naam; ?>" readonly> <br>

        <label for="bedrijfsnaam">Bedrijfsnaam:</label><br>
        <input type="text" name="bedrijfsnaam" id="bedrijfsnaam" value="<?php echo $ondernemerdata->bedrijfsnaam_ond; ?>" required> <br>

        <label for="kvk">KvK nummer:</label><br>
        <input type="text" name="kvknummer" id="kvknummer" value="<?php echo $ondernemerdata->kvk; ?>" required> <br>

        <label for="email">E-mailadres:</label><br>
        <input type="email" name="email" id="email" value="<?php print $ondernemerdata->email; ?>" required> <br>

        <label for="telefoonnummer">Telefoonnummer:</label><br><input type="text" name="telefoonnummer" id="telefoonnummer" value="<?php print $ondernemerdata->tel_nr; ?>" required> <br>
        <input type="submit" name="aanpassen" value="Aanpassen!">

    </form>
    <form action="" method="post">

        <label for="wachtwoord_o">Uw oude wachtwoord:</label><br>
        <input type="password" name="wachtwoord_o" id="wachtwoord" placeholder="Oude wachtwoord" required> <br>

        <label for="wachtwoord_n">Nieuwe wachtwoord:</label><br>
        <input type="password" name="wachtwoord_n" id="wachtwoord" placeholder="Nieuwe wachtwoord" required> <br>

        <label for="wachtwoord_h">Herhaal nieuwe wachtwoord:</label><br>
        <input type="password" name="wachtwoord_h" id="wachtwoord_h" placeholder="Herhaal nieuwe wachtwoord" required><br>

        <input type="submit" name="ww" value="Aanpassen!">
    </form>
    <button onclick="location.href='ondernemer_landing.php';" id="btn_under"><i class="fas fa-chevron-left"></i> Terug</button>

    <h1></h1>
</div>

</body>
</html>
