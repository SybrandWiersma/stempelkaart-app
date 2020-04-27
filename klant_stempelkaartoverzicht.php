<?php
include("config.php");
require("header_klant.php");

?>

<div class="wrapperStempelkaartOverzicht">
    <h1>Uw Stempelkaarten</h1>
    <div class="StempelkaartOverzicht_div">
        <ul style="list-style-type:none;">
            <?php

            $message = "";
            //query om gegevens klant uit de database op te halen
            $sql_klant = "SELECT  * FROM `klanten` WHERE `gebr_naam`='" . $_SESSION['klant'] . "'";
            $sql_query_klant = mysqli_query($con, $sql_klant);
            $result_klant = mysqli_fetch_object($sql_query_klant);

            //query om aantal gekoppelde kaarten te tellen
            $stmt = $con->prepare("SELECT * FROM stempelkaart_klant WHERE klant_id = ?");
            $stmt->bind_param("s", $result_klant->klant_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows < 1) {
                $message = "<h2>U bent nog niet gekoppeld aan een stempelkaart, neem contact op met het bedrijf!</h2>";
            }

            //query om gegevens persoonlijke stempelkaart uit de database op te halen
            $sql_pers = "SELECT  * FROM `stempelkaart_klant` WHERE `klant_id`='" . $result_klant->klant_id . "'";
            $sql_query_pers = mysqli_query($con, $sql_pers);
            while ($result_pers = mysqli_fetch_object($sql_query_pers)) {


                //query om gegevens stempelkaarten waaraan klant is gekoppeld uit de database op te halen
                $sql_kaart = "SELECT  * FROM `stempelkaarten` WHERE `stempelkaart_id`='" . $result_pers->stempelkaart_id . "'";
                $sql_query_kaart = mysqli_query($con, $sql_kaart);
                while ($result_kaart = mysqli_fetch_object($sql_query_kaart)) {
                    ?>


                    <a href='klant_kaartweergeven.php?p=<?php print $result_pers->stempelkaart_id; ?>&o=<?php print $result_klant->klant_id; ?>'>
                        <li class="Stempelkaart">


                            <div id="ond_naam">
                                <h2><?php echo $result_kaart->beloning_label; ?></h2>
                            </div>
                            <div id="aant_stemp">
                                <h2> <?php echo $result_pers->aant_stemps; ?>
                                    /<?php echo $result_kaart->beloning_aantstemps; ?></h2>
                            </div>
                        </li>
                    </a>

                    <?php
                }
            }
            if (!empty($message)) {
                echo $message;
            }
            ?>

        </ul>
    </div>
    <div style="border-bottom: 1px solid #dee0e4"></div>


</div>