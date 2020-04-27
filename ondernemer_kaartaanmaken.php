<?php
include("config.php");
include("functions.php");
$title = "Kaart Aanmaken";
include("header_ondernemer.php");


$message = "";

//na aanmaken kaart
if (isset($_POST['aanmaken'])) {

    //query om ondernemers_id uit de database op te halen
    $result_id = Get_ondernemer_with_Gebrnaam($_SESSION['gebruikersnaam']);

    $aant_stemps = trim($_POST['stemps']);
    $label = trim($_POST['label']);
    $beschrijving = trim($_POST['beschrijving']);

    $klopt = true;

    // Check of alle velden ingevuld zijn
    if ($aant_stemps == '' || $label == '' || $beschrijving == '') {
        $klopt = false;
        $message = "<br><br><strong>Fout! </strong>Het is verplicht om alle velden in te vullen!";
    }

    // Als alles ingevuld is, query uitvoeren om in de database te plaatsen.
    if ($klopt) {
        Insert_kaart($result_id->ondernemer_id, $aant_stemps, $label, $beschrijving);

        $message = " <br><br> <strong>Gelukt!</strong>Uw stempelkaart is aangemaakt!</br>";
    }
}

?>

<div class="wrapper">
    <h1>Kaart aanmaken</h1>
    <form action="" method="post" style="margin-bottom: 15%">
        <p><label for="stemps">Maximaal aantal stempels (1-25):</label> <br><br>
            <input type="number" name="stemps" id="stemps" min="1" max="25" value="1" required> <br><br>
            <label for="label">Naam stempelkaart:</label> <br><br>
            <input type="text" name="label" id="label" placeholder="Naam" required> <br><br>
            <label for="label">Beschrijving beloning:</label> <br><br>
            <textarea name="beschrijving" id="beschrijving" required max="400"
                      placeholder="Beschrijving"></textarea><br>
            <input type="submit" name="aanmaken" style="background-color: #5cb85c" value="Maak kaart aan!">


            <?php
            if (!empty($message)) {
                echo $message;
            }
            ?>


        </p>


    </form>
    <center>
        <input type="button" onclick="location.href='ondernemer_kaartoverzicht.php';" value="Kaarten weergeven">
        <button onclick="location.href='ondernemer_landing.php';" id="btn_under"><i class="fas fa-chevron-left"></i>
            Terug
        </button>
    </center>

    <h2></h2>
</div>


</div>
</body>
</html>