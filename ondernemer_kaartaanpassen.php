<?php
include("config.php");
$title = "Kaart aanpassen";
include("functions.php");

//om fraude te voorkomen eerst een check of er een p en een o meegegeven worden
if (!isset($_GET['p']) && !isset($_GET['o'])) {
    header('Location: 404.php');
} else {

    //query om ondernemers_id uit de database op te halen
    $result_id = Get_ondernemer_with_Gebrnaam($_SESSION['gebruikersnaam']);


    //query om gegevens stempelkaart uit de database op te halen
    $result_stemp = Get_kaart_with_kaartID($_GET['p']);

    //als de meegegeven o niet overeenkomt met het ondernemers id van de ingelogde persoon kom je op 404
    if ($_GET['o'] != $result_id->ondernemer_id) {
        header('Location: 404.php');
    } else {

        include("header_ondernemer.php");

        $message = "";
        //na aanpassen kaart
        if (isset($_POST['aanpassen'])) {


            $aant_stemps = trim($_POST['stemps']);
            $label = trim($_POST['label']);
            $beschrijving = trim($_POST['beschrijving']);

            $klopt = true;

            // Check of alle velden ingevuld zijn
            if ($aant_stemps == '' || $label == '' || $beschrijving == '') {
                $klopt = false;
                $message = "<br><br><strong>Fout! </strong>De velden mogen niet leeg zijn!";
            }

            // Als alles ingevuld is, query uitvoeren om in de database te plaatsen.
            if ($klopt) {
                Update_kaart_aantstemp_label_besch_with_kaartID($aant_stemps, $label, $beschrijving, $_GET['p']);
                $message = "<br><br> <strong>Gelukt!</strong>Uw stempelkaart is aangepast!</br>";
            }
        }

        if (isset($_POST['delete'])) {
            Delete_kaart_with_kaartID($_GET['p']);
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
                        showKaart_ond($result_stemp->beloning_aantstemps, $result_id->stemp_afb);


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
                    if (!empty($message)) {
                        echo $message;
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