<?php
include("config.php");
require("header_ondernemer.php");
?>

<div class="wrapperStempelkaartOverzicht" style="overflow-x:auto; width: 65%">

    <h1>Kaart overzicht</h1>
    <?php
    if (isset($_GET['delete'])) {
        if ($_GET['delete'] == "1") {
            ?>
            <p>
            <center>U heeft uw kaart succesvol verwijderd</center> </p>
            <?php
        }
    }
    ?>
    <table cellspacing='1' class="Kaartoverzicht" align='center' style="margin: 5%; width: 90%; table-layout: fixed;">
        <tr>
            <th width=5%'>
                #
            </th>
            <th width='10%'>

                Naam + beloning
            </th>
            <th width='15%'>
                Beschrijving
            </th>
            <th width='7%'>
                Aantal <br> gekoppelde <br> klanten
            </th>
        </tr>

        <?php
        // dmv iteratie nummer toevoegen aan elke stempelkaart
        $i = 1;

        //query om ondernemers_id uit de database op te halen
        $sql_id = "SELECT  `ondernemer_id` FROM `ondernemers` WHERE `gebr_naam`='" . $_SESSION['gebruikersnaam'] . "'";
        $sql_query_id = mysqli_query($con, $sql_id);
        $result_id = mysqli_fetch_object($sql_query_id);


        //query om kaarten uit de database op te halen, en dmv een lus dat voor elke kaart te doen
        $sql_kaart = "SELECT  * FROM `stempelkaarten` WHERE `ondernemer_id`='" . $result_id->ondernemer_id . "'  ORDER BY `stempelkaart_id` ";
        $sql_query_kaart = mysqli_query($con, $sql_kaart);
        while ($result_kaart = mysqli_fetch_object($sql_query_kaart)) {

            //query om aantal gekoppelde klanten te tellen
            $stmt = $con->prepare("SELECT * FROM stempelkaart_klant WHERE stempelkaart_id = ?");
            $stmt->bind_param("s", $result_kaart->stempelkaart_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            ?>
            <tr>
                <td width='10%'>
                    <?php echo ' ' . $i . ' ';
                    $i++; ?>
                </td>
                <td width='30%'>

                    <a class="buttonnaam" style="background-color: #5cb85c"
                       href='ondernemer_kaartaanpassen.php?p=<?php echo $result_kaart->stempelkaart_id; ?>&o=<?php echo $result_id->ondernemer_id ?>'><?php echo $result_kaart->beloning_label; ?></a>
                </td>
                <td width='30%'>
                    <?php echo $result_kaart->beloning_beschrijving; ?>
                </td>
                <td width='10%'>
                    <?php echo $result->num_rows; ?>
                </td>
            </tr>


            <?php
        }
        ?>

    </table>
    <center>
        <input type="button" onclick="location.href='ondernemer_kaartaanmaken.php';" value="Kaart aanmaken">
        <button onclick="location.href='ondernemer_landing.php';" id="btn_under"><i class="fas fa-chevron-left"></i>
            Terug
        </button>
    </center>

    <h1></h1>
</div>


</div>
</body>
</html>