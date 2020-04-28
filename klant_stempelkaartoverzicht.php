<?php
include("config.php");
$title = "Stempelkaart Informatie";
include("header_klant.php");
include("functions.php");


$result_klant = Get_klant_with_Gebrnaam($_SESSION['klant']);
$result_aantal = Get_link_with_klantID($result_klant->klant_id);
?>

<div class="wrapperStempelkaartOverzicht">
    <h1>Uw Stempelkaarten</h1>
    <div class="StempelkaartOverzicht_div">
        <ul style="list-style-type:none;">
            <?php
            overzichtKaart($con, $result_aantal, $result_klant);
            ?>


        </ul>
    </div>
    <div style="border-bottom: 1px solid #dee0e4"></div>


</div>
</body>
</html>