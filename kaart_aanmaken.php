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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nieuwe kaart aanmaken</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

<?php
    $error_message = "";$success_message = "";
    //na aanmaken kaart
    if(isset($_POST['aanmaken'])){

    //query om ondernemers_id uit de database op te halen
    $sql_id = "SELECT  `ondernemer_id` FROM `ondernemers` WHERE `gebr_naam`='".$_SESSION['gebruikersnaam']."'";
    $sql_query_id = mysqli_query($con,$sql_id);
    $result_id = mysqli_fetch_object($sql_query_id);

    $aant_stemps= trim($_POST['stemps']);
    $label = trim($_POST['label']);
    $beschrijving = trim($_POST['beschrijving']);

    $klopt = true;

    // Check of alle velden ingevuld zijn
    if($aant_stemps == '' || $label == '' || $beschrijving == ''){
    $klopt = false;
    $error_message = "Het is verplicht om alle velden in te vullen!";
   }

   // Als alles ingevuld is, query uitvoeren om in de database te plaatsen.
   if($klopt){
     $insertSQL = "INSERT INTO `stempelkaarten`(`ondernemer_id`, `beloning_aantstemps`, `beloning_label`, `beloning_beschrijving`) VALUES (?,?,?,?)";
     $stmt = $con->prepare($insertSQL);
     $stmt->bind_param("ssss",$result_id->ondernemer_id,$aant_stemps,$label,$beschrijving);
     $stmt->execute();
     $stmt->close();

     $success_message = "Uw stempelkaart is aangemaakt!</br>";
   }
}
?>
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
        <a href="ondernemer_gegevens.php"><i class="fas fa-user-circle"></i>Profiel</a>
        <a href="landing_ondernemer.php?x=uitloggen"><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
    </div>
<?php
 }
 ?>
</nav>
<div class="wrapper">
    <h1>Kaart aanmaken</h1>
    <form action="" method="post">
       <p><label for="stemps">Maximaal aantal stempels (1-25):</label><br><input type="number" name="stemps" id="stemps"  min="1" max="25" value="1" required> <br><br>
       <label for="label">Naam stempelkaart:</label><input type="text" name="label" id="label" placeholder="Naam + beloning" required> <br>
       <label for="label">Beschrijving beloning:</label><input type="text" name="beschrijving" id="beschrijving" placeholder="Beschrijving beloning" required max="400"> <br>
        <input type="submit" name="aanmaken" value="Maak kaart aan!">
        
            <?php 
            // Foutmelding
            if(!empty($error_message)){
            ?>
            
              <br><br><strong>Fout!  </strong> <?= $error_message ?> 
           

            <?php
            }
            ?>

            <?php 
            // Aanmaken gelukt
            if(!empty($success_message)){
            ?>
          
             <br><br> <strong>Gelukt!</strong> <?= $success_message ?> 
           

            <?php
            }
            ?>
            
            </p>


       </form>
       <center>
       <input type="button" onclick="location.href='ondernemer_kaartoverzicht.php';" value="Kaarten weergeven">
    <button onclick="location.href='landing_ondernemer.php';" id="btn_under"><i class="fas fa-chevron-left"></i> Terug</button>
       </center>

         <h1></h1>
</div>
        
        
        



</div>
</body>
</html>