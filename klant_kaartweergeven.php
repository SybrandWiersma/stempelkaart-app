<?php
include("config.php");

//om fraude te voorkomen eerst een check of er een p en een o meegegeven worden
if (!isset($_GET['p']) && !isset($_GET['o'])) {
    header('Location: 404.php');
} else {

    $klant = Get_klant_with_Gebrnaam($_SESSION['klant']);
    $stempelkaart = Get_kaart_with_ID($_GET['p']);
    $result_ond = Get_ondernemer_with_ID($stempelkaart->ondernemer_id);
    $result_aant = Get_link_with_kaartID($_GET['p']);

    //als de meegegeven o niet overeenkomt met het klanten id van de ingelogde persoon kom je op 404
    if ($_GET['o'] != $klant->klant_id) {
        header('Location: 404.php');
    } else {

        include("header_klant.php");
        include("functions.php");

        ?>

        <div class="wrapper" style="overflow-x:auto;">

            <h1><?php echo $stempelkaart->beloning_label; ?></h1>
            <center><font color="<?php echo $result_ond->kleur1; ?>">
                    <?php echo $stempelkaart->beloning_beschrijving; ?><br>
                </font>

                <img src="<?php echo $result_ond->logo; ?>" width="250px" height="170px">
                <table bgcolor="<?php echo $result_ond->kleur2; ?>" class="noBorder">
                    <tr>
                        <?php showKaart($result_aant->aant_stemps, $result_ond->stemp_afb, $stempelkaart->beloning_aantstemps); ?>


                    </tr>
                </table>
                <?php toonQR($_GET['p'], $_GET['o'], $klant->klant_id, $stempelkaart->stempelkaart_id); ?>
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