<?php
include("config.php");
require("header_klant.php");

//om fraude te voorkomen eerst een check of er een p en een o meegegeven worden
if (!isset($_GET['p']) && !isset($_GET['o'])) {
    header('Location: 404.php');
} else {

    //query om klant gegevens uit de database op te halen
    $sql_id = "SELECT  * FROM `klanten` WHERE `gebr_naam`='" . $_SESSION['klant'] . "'";
    $sql_query_id = mysqli_query($con, $sql_id);
    $result_id = mysqli_fetch_object($sql_query_id);

    //query om gegevens stempelkaart uit de database op te halen
    $sql_stemp = "SELECT  * FROM `stempelkaarten` WHERE `stempelkaart_id`='" . $_GET['p'] . "'";
    $sql_query_stemp = mysqli_query($con, $sql_stemp);
    $result_stemp = mysqli_fetch_object($sql_query_stemp);

    //query om ondernemers gegevens uit de database op te halen voor afbeeldingen
    $sql_ond = "SELECT  * FROM `ondernemers` WHERE `ondernemer_id`='" . $result_stemp->ondernemer_id . "'";
    $sql_query_ond = mysqli_query($con, $sql_ond);
    $result_ond = mysqli_fetch_object($sql_query_ond);

    //query om aantal stempels  uit de database op te halen 
    $sql_aant = "SELECT  * FROM `stempelkaart_klant` WHERE `stempelkaart_id`='" . $_GET['p'] . "'";
    $sql_query_aant = mysqli_query($con, $sql_aant);
    $result_aant = mysqli_fetch_object($sql_query_aant);

    //als de meegegeven o niet overeenkomt met het ondernemers id van de ingelogde persoon kom je op 404
    if ($_GET['o'] != $result_id->klant_id) {
        header('Location: 404.php');
    } else {


        ?>

        <div class="wrapper" style="overflow-x:auto;">

            <h1><?php echo $result_stemp->beloning_label; ?></h1>
            <center><font color="<?php print $result_ond->kleur1; ?>">
                    <?php echo $result_stemp->beloning_beschrijving; ?><br>
                </font>

                <img src="<?php print $result_ond->logo; ?>" width="250px" height="170px">
                <table bgcolor="<?php print $result_ond->kleur2; ?>" class="noBorder">
                    <tr>
                        <?php

                        //for loop om vakken te weergeven MET stempel erin
                        for ($i = 1;
                        $i <= $result_aant->aant_stemps;
                        $i += 1){


                        if ($i == 6 || $i == 12 || $i == 18 || $i == 24 || $i == 25){
                        ?>
                        <td width="15%">
                            <img src="<?php print $result_ond->stemp_afb; ?>" width="50px" heigth="50px">
                        </td>
                    </tr>
                    <tr>
                        <?php
                        } else {
                            ?>

                            <td width="15%">
                                <img src="<?php print $result_ond->stemp_afb; ?>" width="50px" heigth="50px">
                            </td>

                            <?php
                        }
                        }
                        ?>

                        <?php

                        //for loop om vakken te weergeven ZONDER stempel erin
                        for ($x = 1;
                        $x <= $result_stemp->beloning_aantstemps - $result_aant->aant_stemps;
                        $x += 1){


                        if ($x + $result_aant->aant_stemps == 6 || $x + $result_aant->aant_stemps == 12 || $x + $result_aant->aant_stemps == 18 || $x + $result_aant->aant_stemps == 24 || $x + $result_aant->aant_stemps == 25){
                        ?>
                        <td width="15%" height="70px">
                        </td>
                    </tr>
                    <tr>
                        <?php
                        } else {
                            ?>

                            <td width="15%" height="70px">
                            </td>

                            <?php
                        }
                        }
                        ?>


                    </tr>


                </table>
                <?php
                if (!isset($_GET['z'])) {
                    ?>
                    <button onclick="location.href='klant_kaartweergeven.php?p=<?php print $_GET['p']; ?>&o=<?php print $_GET['o']; ?>&z=toon';"
                            id="btn_under"> Toon QR
                    </button>

                    <?php
                }
                if (isset($_GET['z'])) {
                    if ($_GET['z'] == "toon") {
                        ?>
                        <button onclick="location.href='klant_kaartweergeven.php?p=<?php print $_GET['p']; ?>&o=<?php print $_GET['o']; ?>';"
                                id="btn_under"> Verberg QR
                        </button>
                        <img src="https://chart.googleapis.com/chart?cht=qr&chl=klantid%3D<?php print $result_id->klant_id ?>%26kaartid%3D<?php print $result_stemp->stempelkaart_id ?>&choe=UTF-8&chs=400x400">
                        <?php
                    }
                }
                ?>
                <button onclick="location.href='klant_stempelkaartoverzicht.php';" id="btn_under"><i
                            class="fas fa-chevron-left"></i> Terug
                </button>
            </center>

            <h1></h1>
        </div


        </div>
        </body>
        </html>

        <?php
    }
}
?>