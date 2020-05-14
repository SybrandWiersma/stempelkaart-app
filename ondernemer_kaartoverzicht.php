<?php
include("config.php");
include("functions/functions.php");
$title = "Kaart overzicht";
include("headers/header_ondernemer.php");
$bericht = "";
if (isset($_GET['delete'])) {
    if ($_GET['delete'] == "1") {
        $bericht = "<p>
            <center>U heeft uw kaart succesvol verwijderd</center> </p>";
    }
}
?>

<div class="wrapperStempelkaartOverzicht" style="overflow-x:auto; width: 65%">

    <h1>Kaart overzicht</h1>
    <?php
    if (!empty($bericht)) {
        echo $bericht;
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
        getKaart($_SESSION['gebruikersnaam']);
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