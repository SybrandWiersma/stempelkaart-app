<?php
include("config.php");

// Check of gebruiker ingelogd is of niet
if(!isset($_SESSION['gebruikersnaam'])){
    header('Location: index.php');
}
// Uitloggen (eerste check of er een 'x' in de browser meegegeven wordt, zoja als dat uitloggen is word je uitgelogd)
if(isset($_GET['x'])){
    if($_GET['x'] == "uitloggen"){
    session_destroy();
    header('Location: index.php');
    }
}
//query om logo uit de database op te halen
$sql_logo = "SELECT  `logo` FROM `ondernemers` WHERE `gebr_naam`='".$_SESSION['gebruikersnaam']."'";
$sql_query_logo = mysqli_query($con,$sql_logo);
$result_logo = mysqli_fetch_object($sql_query_logo);

//query om kleur 1 uit de database op te halen
$sql_achtergrond = "SELECT  `kleur1` FROM `ondernemers` WHERE `gebr_naam`='".$_SESSION['gebruikersnaam']."'";
$sql_query_achtergrond = mysqli_query($con,$sql_achtergrond);
$result_achtergrond = mysqli_fetch_object($sql_query_achtergrond);

//query om kleur 2 uit de database op te halen
$sql_letter = "SELECT  `kleur2` FROM `ondernemers` WHERE `gebr_naam`='".$_SESSION['gebruikersnaam']."'";
$sql_query_letter = mysqli_query($con,$sql_letter);
$result_letter = mysqli_fetch_object($sql_query_letter);




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Huisstijl aanpassen</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<nav class="navtop">
<?php
if(!isset($_SESSION['gebruikersnaam'])){

?>

    <div>
       <h1><a href="index.php">StempelkaartApp</a></h1>
        <a href="ond_registratie.php"><i class="fas fa-user-circle"></i>Registreren als ondernemer</a>
        <a href="klant_registratie.php"><i class="fas fa-user-circle"></i>Registreren als klant</a>
        <a href="loginpage.php"><i class="fas fa-sign-out-alt"></i>Inloggen</a>
    </div>
<?php
} else {
?>
    <div>
        <h1><a href="landing_ondernemer.php">StempelkaartApp</a></h1> 
        <a href=""><i class="fas fa-user-circle"></i>Profiel</a>
        <a href="landing_ondernemer.php?x=uitloggen"><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
    </div>
<?php
 }
 ?>
</nav>
<div class="wrapper">
    <h1>Huisstijl aanpassen</h1>
    <center>

      <p>Verander logo: </p>
    <img src="<?php print $result_logo->logo; ?>"  width="250" heigth="250"><br>
    <form action="huisstijl.php" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" name="submit"   value="Wijzig logo">
    </form>

    <?php
    // Check of upload een afbeelding is of niet
if(isset($_POST["submit"])) {
$target_dir = "images/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "U heeft iets anders dan een afbeelding geselecteerd.";
        $uploadOk = 0;
    }
    // Check of bestand al in de database voorkomt
if (file_exists($target_file)) {
    echo "Sorry, dit bestand bestaat al in onze database, geef het bestand een andere naam.";
    $uploadOk = 0;
}

// Sta alleen enkele typen afbeeldingen toe
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, alleen JPG, JPEG, PNG & GIF bestanden zijn toegestaan.";
    $uploadOk = 0;
}

// Check of er iets fout is gegaan
if ($uploadOk == 0) {
    echo "";
// Als er geen fout is teruggegeven, wordt bestand geupload
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $update_query = "UPDATE `ondernemers` SET `logo`='".$target_file."' WHERE `gebr_naam`='".$_SESSION['gebruikersnaam']."'";
        $sql_update = mysqli_query($con,$update_query);
        header("Refresh:0");


    } else {
        echo "";
    }
}


}

    ?>

    <br>
    <br>


    Verander letter kleur:
    <form action="huisstijl.php" method="post" enctype="multipart/form-data">
    <div><input type="color" name="letter"value="<?php print $result_achtergrond->kleur1 ?>"> <input type="submit" class="kleinebutton" name="send"  value="Wijzig kleur"></div>
   </form>

   <?php
   if(isset($_POST["send"])) {
   $update_query = "UPDATE `ondernemers` SET `kleur1`='".$_POST['letter']."' WHERE `gebr_naam`='".$_SESSION['gebruikersnaam']."'";
   $sql_update = mysqli_query($con,$update_query);
   echo "U heeft de kleur van uw letters aangepast!";
   
   }
   ?>
   <br><br>
    Verander achtergrond kleur:  
   <form action="huisstijl.php" method="post" enctype="multipart/form-data">
   <div><input type="color" name="back" value="<?php print $result_letter->kleur2 ?>"> <input type="submit" class="kleinebutton" name="send2" value="Wijzig kleur"></div>
   </form>

      <?php
   if(isset($_POST["send2"])) {
   $update_query = "UPDATE `ondernemers` SET `kleur2`='".$_POST['back']."' WHERE `gebr_naam`='".$_SESSION['gebruikersnaam']."'";
   $sql_update = mysqli_query($con,$update_query);
   echo "U heeft de kleur van uw achtergrond aangepast!";
   
   }
   ?>
   <br>
          <button onclick="location.href='landing_ondernemer.php';" id="btn_under"><i class="fas fa-chevron-left"></i> Terug</button>


         <h1></h1>
    </center>


 
    </div>


        
        
        



</div>
</body>
</html>