<?php
include("config.php");

// Haalt de klant id en kaart id op die mee gegeven zijn met de pagina
$klant_id = $_GET['klantid'];
$kaart_id = $_GET['kaartid'];

// Haalt de ondernemer id uit de database met de gebruikersnaam uit de sessie
$ondernemerdata = Get_ondernemer_with_Gebrnaam($_SESSION['gebruikersnaam']);
$kaartdata = Get_kaart_with_kaartID_ondID($kaart_id,$ondernemerdata->ondernemer_id);
$klantdata = Get_klant_with_klantID($klant_id);
$linkdata = Get_link_with_kaartID_klantID($kaart_id, $klant_id);
$ondernemerkaarten = Get_kaarten_with_ondID($ondernemerdata->ondernemer_id);

// Als er niets is mee gegeven word de error pagina weergeven
if (!isset($klant_id) && !isset($kaart_id)) {
    header('Location: 404.php');
}

// Checkt of de klant een kaart heeft bij de ondernemer zodat een ondernemer niet bij klanten van andere ondernemers kan
if ($kaartdata == null) {
    header('Location: 404.php');
}


// checkt of de ondernemer een aanvraag heeft gedaan om stempels toe te voegen
if (isset($_POST['stempelzetten']) && isset($_POST['stempel_aantal'])) {

    // Checkt of het aantal toe te voegen stempels niet groter is dan het aantal dat je kan toevoegen
    if ($_POST['stempel_aantal'] > ($kaartdata->beloning_aantstemps - $linkdata->aant_stemps) || $_POST['stempel_aantal'] <= 0) {
        header('Location: 404.php');
    }

    // berekent het nieuwe stempel aantal
    $linkdata->aant_stemps += $_POST['stempel_aantal'];

    // Update het stempelaantal in database
    Update_link_aantstemps_with_kaartID_klantID($linkdata->aant_stemps, $kaart_id, $klant_id);

    // Zorgt er voor dat er een upate message word weergeven
    $stempeltoegevoegdmessage = "stempel(s) toegevoegd";
}

// Checkt of de ondernemer een kaart wil verzilveren
if (isset($_POST['kaartverzilveren'])) {

    // Checkt of de kaart daadwerkelijk vol is
    if (!($linkdata->aant_stemps == $kaartdata->beloning_aantstemps)) {
        header('Location: 404.php');
    }

    // Verzilvert de kaart in de database dus zet stempelaantal op 0
    Update_link_aantstemps_with_kaartID_klantID(0, $kaart_id, $klant_id);

    // Zet aantal stempels lokaal ook op nul zodat dit gelijk weergeven wordt
    $linkdata->aant_stemps = 0;

    // Zorgt er voor dat er een upate message word weergeven
    $stempelkaartverzilverdmessage = "stempelkaart verzilverd";
}


// Checkt of de ondernemer een kaart wil wijzigen
if (isset($_POST['kaartwijzigen']) && isset($_POST['geselecteerde_kaart'])) {

    // Haalt gegevens op van geselecteerde kaart
    $kaartdata_geselecteerd = Get_kaart_with_kaartID_ondID($_POST['geselecteerde_kaart'], $ondernemerdata->ondernemer_id);

    // checkt of de kaart die de ondernemer heeft geselecteerd van hem is
    if ($kaartdata_geselecteerd == null) {
        header('Location: 404.php');
    }

    // Checkt of het aantal stempels van de geselecteerde kaart kleiner is dan van de huidige kaart
    if ($kaartdata_geselecteerd->beloning_aantstemps < $linkdata->aant_stemps) {

        // Wanneer kleiner wordt het maximale van de geselecteerde mee gegeven
        $aantal_stempels = $kaartdata_geselecteerd->beloning_aantstemps;
    } else {

        // Bij groter, het aantal op de huidige
        $aantal_stempels = $linkdata->aant_stemps;
    }

    Update_link_kaartID_aantstemps_with_klantID_kaartID($kaartdata_geselecteerd->stempelkaart_id, $aantal_stempels, $klant_id, $kaart_id);

    $linkdata->aant_stemps = $aantal_stempels;
    $linkdata->kaart_id = $kaartdata_geselecteerd->stempelkaart_id;

}

require("headers/header_ondernemer.php");

?>
<div class="wrapperQRinfo">
    <h1>QR-Code Informatie</h1>

    <h4>Naam</h4>
    <p><?php echo $klantdata->naam_klant ?></p>
    <h4>Aantal stempels</h4>
    <p><?php echo $linkdata->aant_stemps . " / " . $kaartdata->beloning_aantstemps ?></p>
    <h4>Beloning</h4>
    <p><?php echo $kaartdata->beloning_label ?></p>


    <form action="ondernemer_qrcode_gescand.php?kaartid=<?php echo $kaart_id ?>&klantid=<?php echo $klant_id ?>"
          method="post">
        <h4>Stempels Toevoegen</h4> <input type="number" name="stempel_aantal" value="0" min="1"
                                           max="<?php echo $kaartdata->beloning_aantstemps - $linkdata->aant_stemps ?>">
        <!--max moet resterend aantal stempels zijn!-->
        <div style="border-bottom: 1px solid #dee0e4"></div>
        <button <?php if ($linkdata->aant_stemps == $kaartdata->beloning_aantstemps) echo "style =\"background-color:#4d5563; opacity:50%\" disabled" ?>
                name="stempelzetten" type="submit">Stempel(s) Zetten
        </button>
        <?php if (isset($stempeltoegevoegdmessage)) echo "<br><br>" . $stempeltoegevoegdmessage . "<br>" ?>
    </form>


    <form action="ondernemer_qrcode_gescand.php?kaartid=<?php echo $kaart_id ?>&klantid=<?php echo $klant_id ?>"
          method="post">
        <button <?php if ($linkdata->aant_stemps != $kaartdata->beloning_aantstemps) echo "style =\"background-color:#4d5563; opacity:50%\" disabled"; ?>
                name="kaartverzilveren" type="submit">Kaart Verzilveren
        </button>
        <?php if (isset($stempelkaartverzilverdmessage)) echo "<br><br>" . $stempelkaartverzilverdmessage . "<br>" ?>
    </form>

    <div style="margin-top:4%; border-bottom: 1px solid #dee0e4"></div>

    <form action="ondernemer_qrcode_gescand.php?kaartid=<?php echo $kaart_id ?>&klantid=<?php echo $klant_id ?>"
          method="post">
        <br><select name="geselecteerde_kaart">
            <?php while ($row = mysqli_fetch_array($ondernemerkaarten)) {
                echo "<option value='" . $row['stempelkaart_id'] . "'>" . $row['beloning_label'] . "</option>";
            } ?>
        </select><br>
        <button type="submit" name="kaartwijzigen">Kaart Wijzigen</button>
    </form>
    <div style="margin-top:4%; border-bottom: 1px solid #dee0e4"></div>

    <button onclick="location.href='ondernemer_landing.php';" style="width: 40%; margin-bottom: 5%" id="btn_under"><i class="fas fa-chevron-left"></i> Terug</button>
    </br>

</div>

</body>
</html>