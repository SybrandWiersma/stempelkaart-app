<?php
include("config.php");
include("functions/functions.php");
$title = "Huisstijl Aanpassen";
include("headers/header_ondernemer.php");
$result = Get_ondernemer_with_Gebrnaam($_SESSION['gebruikersnaam']);


if (uploadLogo($_SESSION['gebruikersnaam'])) {
    return uploadLogo($_SESSION['gebruikersnaam']);
}
if (uploadStempel($_SESSION['gebruikersnaam'])) {
    return uploadStempel($_SESSION['gebruikersnaam']);
}
if (isset($_POST["send"])) {
    Update_ondernemer_kleur1_with_Gebrnaam($_POST['letter'], $_SESSION['gebruikersnaam']);
    header("Refresh:0");

}

if (isset($_POST["send2"])) {
    Update_ondernemer_kleur2_with_Gebrnaam($_POST['back'], $_SESSION['gebruikersnaam']);
    header("Refresh:0");

}

?>

<div class="wrapper">
    <h1>Huisstijl aanpassen</h1>

    <p>Verander logo: </p>
    <img src="<?php print $result->logo; ?>" width="250" heigth="250"><br>
    <form action="ondernemer_huisstijlaanpassen.php" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" name="submit" value="Wijzig logo">
    </form>


    <br>
    <p>Verander stempel: </p>
    <img src="<?php print $result->stemp_afb; ?>" width="50px" heigth="50px"><br>
    <form action="ondernemer_huisstijlaanpassen.php" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload2" id="fileToUpload2">
        <input type="submit" name="submit2" value="Wijzig stempel">
    </form>


    <br>


    <p>Verander tekstkleur:</p>
    <form action="ondernemer_huisstijlaanpassen.php" method="post" enctype="multipart/form-data">
        <div>
            <input type="color" name="letter" value="<?php print $result->kleur1 ?>"><br>
            <input type="submit" name="send" value="Wijzig kleur">
        </div>
    </form>


    <br>

    <p>Verander achtergrondkleur:</p>
    <form action="ondernemer_huisstijlaanpassen.php" method="post" enctype="multipart/form-data">
        <div><input type="color" name="back" value="<?php print $result->kleur2 ?>"><br>
            <input type="submit" name="send2" value="Wijzig kleur"></div>
    </form>

    <br>
    <button onclick="location.href='ondernemer_landing.php';" id="btn_under"><i class="fas fa-chevron-left"></i> Terug
    </button>

    <h2></h2>

</div>


</div>
</body>
</html>
