<?php
include("config.php");
require("header_ondernemer.php");

    $error_message = "";
    $success_message = "";
    //na aanmaken kaart
    if (isset($_POST['aanmaken'])) {

        //query om ondernemers_id uit de database op te halen
        $sql_id = "SELECT  `ondernemer_id` FROM `ondernemers` WHERE `gebr_naam`='" . $_SESSION['gebruikersnaam'] . "'";
        $sql_query_id = mysqli_query($con, $sql_id);
        $result_id = mysqli_fetch_object($sql_query_id);

        $aant_stemps = trim($_POST['stemps']);
        $label = trim($_POST['label']);
        $beschrijving = trim($_POST['beschrijving']);

        $klopt = true;

        // Check of alle velden ingevuld zijn
        if ($aant_stemps == '' || $label == '' || $beschrijving == '') {
            $klopt = false;
            $error_message = "Het is verplicht om alle velden in te vullen!";
        }

        // Als alles ingevuld is, query uitvoeren om in de database te plaatsen.
        if ($klopt) {
            $insertSQL = "INSERT INTO `stempelkaarten`(`ondernemer_id`, `beloning_aantstemps`, `beloning_label`, `beloning_beschrijving`) VALUES (?,?,?,?)";
            $stmt = $con->prepare($insertSQL);
            $stmt->bind_param("ssss", $result_id->ondernemer_id, $aant_stemps, $label, $beschrijving);
            $stmt->execute();
            $stmt->close();

            $success_message = "Uw stempelkaart is aangemaakt!</br>";
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
            // Foutmelding
            if (!empty($error_message)) {
                ?>

                <br><br><strong>Fout! </strong> <?= $error_message ?>


                <?php
            }
            ?>

            <?php
            // Aanmaken gelukt
            if (!empty($success_message)) {
                ?>

                <br><br> <strong>Gelukt!</strong> <?= $success_message ?>


                <?php
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