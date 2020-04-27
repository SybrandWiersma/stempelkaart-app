<?php
include("config.php");
require("header_ondernemer.php");

//om fraude te voorkomen eerst een check of er een p en een o meegegeven worden
if (!isset($_GET['p']) && !isset($_GET['o'])) {
    header('Location: 404.php');
} else {

    //query om ondernemers_id uit de database op te halen
    $sql_id = "SELECT  * FROM `ondernemers` WHERE `gebr_naam`='" . $_SESSION['gebruikersnaam'] . "'";
    $sql_query_id = mysqli_query($con, $sql_id);
    $result_id = mysqli_fetch_object($sql_query_id);

    //query om gegevens stempelkaart uit de database op te halen
    $sql_stemp = "SELECT  * FROM `stempelkaarten` WHERE `stempelkaart_id`='" . $_GET['p'] . "'";
    $sql_query_stemp = mysqli_query($con, $sql_stemp);
    $result_stemp = mysqli_fetch_object($sql_query_stemp);

    //als de meegegeven o niet overeenkomt met het ondernemers id van de ingelogde persoon kom je op 404
    if ($_GET['o'] != $result_id->ondernemer_id) {
        header('Location: 404.php');
    } else {


        $error_message = "";
        $success_message = "";
        //na aanpassen kaart
        if (isset($_POST['aanpassen'])) {


            $aant_stemps = trim($_POST['stemps']);
            $label = trim($_POST['label']);
            $beschrijving = trim($_POST['beschrijving']);

            $klopt = true;

            // Check of alle velden ingevuld zijn
            if ($aant_stemps == '' || $label == '' || $beschrijving == '') {
                $klopt = false;
                $error_message = "De velden mogen niet leeg zijn!";
            }

            // Als alles ingevuld is, query uitvoeren om in de database te plaatsen.
            if ($klopt) {
                $updateSQL = "UPDATE `stempelkaarten` SET `beloning_aantstemps`='" . $aant_stemps . "', `beloning_label`='" . $label . "', `beloning_beschrijving`='" . $beschrijving . "' WHERE `stempelkaart_id`='" . $_GET['p'] . "'";
                $stmt = $con->prepare($updateSQL);
                $stmt->execute();
                $stmt->close();

                $success_message = "Uw stempelkaart is aangepast!</br>";
            }
        }

        if (isset($_POST['delete'])) {
            $deleteSQL = "DELETE FROM `stempelkaarten` WHERE `stempelkaarten`.`stempelkaart_id` ='" . $_GET['p'] . "'";
            $stmt = $con->prepare($deleteSQL);
            $stmt->execute();
            $stmt->close();
            header('Location: ondernemer_kaartoverzicht.php?delete=1');
        }
        ?>

        <div class="wrapperStempelkaartOverzicht" style="overflow-x:auto;">

            <h1>Kaart aanpassen</h1>
            <center>
                <h2><?php echo $result_stemp->beloning_label; ?></h2>
                <img src="<?php print $result_id->logo; ?>" width="250px" height="170px">
                <table class="noBorder" style="border-collapse: separate; border-spacing: 10px; margin-bottom: 1%">
                    <tr>
                        <?php


                        for ($x = 1;
                        $x <= $result_stemp->beloning_aantstemps;
                        $x += 1){
                        if ($x == 6 || $x == 12 || $x == 18 || $x == 24 || $x == 25){
                        ?>
                        <td width="15%" style="border-radius: 5px">
                            <img src="<?php print $result_id->stemp_afb; ?>" width="50px" height="50px">
                        </td>
                    </tr>
                    <tr>
                        <?php
                        } else {
                            ?>

                            <td width="15%" style="border-radius: 5px">
                                <img src="<?php print $result_id->stemp_afb; ?>" width="50px" height="50px">
                            </td>

                            <?php

                        }
                        }
                        ?>
                    </tr>


                </table>
            </center>

            <form action="" method="post" style="margin-bottom: 25%">
                <p><label for="stemps">Maximaal aantal stempels aanpassen (1-25):</label><br>
                    <input type="number" style="margin-top: 3.5%; margin-bottom: 3%;" name="stemps" id="stemps" min="1"
                           max="25" value="<?php print $result_stemp->beloning_aantstemps; ?>" required> <br><br>
                    <label for="label">Naam stempelkaart aanpassen:</label>
                    <input type="text" style="margin-top: 3.5%; margin-bottom: 7%;" name="label" id="label"
                           value="<?php print $result_stemp->beloning_label; ?>" required> <br>
                    <label for="label">Beschrijving beloning aanpassen:</label><br><br>
                    <textarea name="beschrijving" id="beschrijving" required
                              max="400"><?php print $result_stemp->beloning_beschrijving; ?></textarea> <br>
                    <input type="submit" style="background-color: #5cb85c" name="aanpassen" value="Pas kaart aan">

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
                <button onclick="location.href='ondernemer_klantkoppelen.php?k=<?php print $_GET['p']; ?>&o=<?php print $_GET['o']; ?>';"
                        id="btn_under">Kaart aan klant koppelen
                </button>
            </center>


            <form action="" method="post">
                <input type="submit" style="background-color:red;" name="delete" value="Verwijder kaart">
            </form>

            <center>
                <button onclick="location.href='ondernemer_kaartoverzicht.php';" id="btn_under"><i
                            class="fas fa-chevron-left"></i> Terug
                </button>
            </center>

            <h2></h2>
        </div>


        </div>
        </body>
        </html>

        <?php
    }
}
?>