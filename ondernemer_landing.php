<?php
include ("config.php");
require ("header_ondernemer.php");
?>
<div class="wrapper">
    <h1>Ondernemerspagina</h1>
    <form action="">
        <input type="button" onclick="location.href='ondernemer_qrscannen.php';" value="QR Scanner">
        <input type="button" onclick="location.href='ondernemer_huisstijlaanpassen.php';" value="Huisstijl Aanpassen">
        <input type="button" onclick="location.href='ondernemer_kaartaanmaken.php';" value="Kaart Aanmaken">
        <input type="button" onclick="location.href='ondernemer_kaartoverzicht.php';" value="Kaarten Weergeven">
        <input type="button" onclick="location.href='ondernemer_gegevensbekijken.php';"
               value="Gegevens Bekijken/Wijzigen">
        <input type="button" style="background-color: #d9534f"
               onclick="location.href='ondernemer_landing.php?x=uitloggen';" value="Uitloggen">
        <h1></h1>
</div>
</form>
</body>
</html>