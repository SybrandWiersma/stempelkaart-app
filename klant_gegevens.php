<?php
include("config.php");
include("functions_gebruikergegevens.php");

//query om klant gegevens uit de database op te halen
$klantdata = Get_klant_with_Gebrnaam($_SESSION['klant']);

// Wachtwoord aanpassen
if (isset($_POST['ww'])) {
    $message = CreateMessage(UpdateWachtwoord($_POST['wachtwoord_o'], $_POST['wachtwoord_n'], $_POST['wachtwoord_h'], $klantdata, 'klant'));
}

// email of telefoonnummer aanpassen
if (isset($_POST['aanpassen'])) {

    if($klantdata->tel_nr != $_POST['telefoonnummer']){
        $message1 = CreateMessage(UpdateTelnr($_POST['telefoonnummer'], $klantdata->gebr_naam, 'klant'));
        if($message1[0] == 'G') $klantdata->tel_nr = $_POST['telefoonnummer'];
    }

    if($klantdata->email != $_POST['email']){
        $message2 = UpdateEmail($_POST['email'], $klantdata->gebr_naam, 'klant');
        if($message2[0] == 'G') $klantdata->email = $_POST['email'];

    }

    if (isset($message1)) {
        if (isset($message2)) {
            $message = CreateMessage($message1) . CreateMessage($message2);
        }
        else {
            $message = CreateMessage($message1);
        }
    } elseif (isset($message2)) {
        $message = CreateMessage($message2);
    } else {
        $message = CreateMessage("FNiks aangepast");
    }
}

require("header_klant.php");
?>



<div class="wrapper">
    <h1>Gegevens bekijken/aanpassen</h1>
    <form action="" method="post">
        <?php if (isset($message)) echo $message ?>
        <p>
            <label for="gebruikersnaam">Gebruikersnaam:</label><br>
            <input type="text" name="gebruikersnaam" id="gebruikersnaam" value="<?php echo $klantdata->gebr_naam ?>" disabled> <br>

            <label for="email">E-mailadres:</label><br>
            <input type="email" name="email" id="email" value="<?php echo $klantdata->email; ?>" required> <br>

            <label for="telefoonnummer">Telefoonnummer:</label><br>
            <input type="text" name="telefoonnummer" id="telefoonnummer" value="<?php print $klantdata->tel_nr ?>" required> <br>

            <input type="submit" name="aanpassen" value="Aanpassen!">
        </p>
    </form>
    <form action="" method="post">
        <label for="wachtwoord_o">Uw oude wachtwoord:</label><br>
        <input type="password" name="wachtwoord_o" id="wachtwoord" placeholder="Oude wachtwoord" required> <br>

        <label for="wachtwoord_n">Nieuwe wachtwoord:</label><br>
        <input type="password" name="wachtwoord_n" id="wachtwoord" placeholder="Nieuwe wachtwoord" required> <br>

        <label for="wachtwoord_h">Herhaal nieuwe wachtwoord:</label><br>
        <input type="password" name="wachtwoord_h" id="wachtwoord_h" placeholder="Herhaal nieuwe wachtwoord" required> <br>

        <input type="submit" name="ww" value="Aanpassen!">
    </form>
    <button onclick="location.href='klant_stempelkaartoverzicht.php';" id="btn_under"><i
                class="fas fa-chevron-left"></i> Terug
    </button>

    <h1></h1>
</div>

</body>
</html>
