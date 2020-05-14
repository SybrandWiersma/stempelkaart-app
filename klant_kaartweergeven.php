<?php
include("config.php");

//om fraude te voorkomen eerst een check of er een p en een o meegegeven worden
if (!isset($_GET['p']) && !isset($_GET['o'])) {
    header('Location: 404.php');
}

$klantdata = Get_klant_with_Gebrnaam($_SESSION['klant']);
$kaartdata = Get_kaart_with_kaartID($_GET['p']);
$ondernemerdata = Get_ondernemer_with_ID($kaartdata->ondernemer_id);
$linkdata = Get_link_with_kaartID_klantID($_GET['p'], $klantdata->klant_id);


//als de meegegeven o niet overeenkomt met het klanten id van de ingelogde persoon kom je op 404
if ($_GET['o'] != $klantdata->klant_id) {
    header('Location: 404.php');
}

include("headers/header_klant.php");
include("functions/functions.php");

?>

<div class="wrapper" style="overflow-x:auto;">

    <h1><?php echo $kaartdata ->beloning_label; ?></h1>
    <center><p color="<?php echo $ondernemerdata->kleur1; ?>">
            <?php echo $kaartdata->beloning_beschrijving; ?><br>
        </p>

        <img src="<?php echo $ondernemerdata->logo; ?>" width="250px" height="170px">
        <table bgcolor="<?php echo $ondernemerdata->kleur2; ?>" class="noBorder">
            <tr>
                <?php  showKaart($linkdata->aant_stemps, $ondernemerdata->stemp_afb, $kaartdata->beloning_aantstemps); ?>


            </tr>
        </table>
        <?php toonQR($_GET['p'], $_GET['o'], $klantdata->klant_id, $kaartdata->stempelkaart_id); ?>
        <button onclick="location.href='klant_stempelkaartoverzicht.php';" id="btn_under"><i
                    class="fas fa-chevron-left"></i> Terug
        </button>
    </center>

    <h1></h1>
</div


</div>
</body>
</html>
