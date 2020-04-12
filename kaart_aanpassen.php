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


//om fraude te voorkomen eerst een check of er een p en een o meegegeven worden
if(!isset($_GET['p']) && !isset($_GET['o'])){
        header('Location: 404.php');
} else {

    //query om ondernemers_id uit de database op te halen
    $sql_id = "SELECT  `ondernemer_id` FROM `ondernemers` WHERE `gebr_naam`='".$_SESSION['gebruikersnaam']."'";
    $sql_query_id = mysqli_query($con,$sql_id);
    $result_id = mysqli_fetch_object($sql_query_id);

   //query om gegevens stempelkaart uit de database op te halen
    $sql_stemp = "SELECT  * FROM `stempelkaarten` WHERE `stempelkaart_id`='".$_GET['p']."'";
    $sql_query_stemp = mysqli_query($con,$sql_stemp);
    $result_stemp = mysqli_fetch_object($sql_query_stemp);

    //als de meegegeven o niet overeenkomt met het ondernemers id van de ingelogde persoon kom je op 404
    if($_GET['o'] != $result_id->ondernemer_id){
                header('Location: 404.php');
	} else {
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kaart aanpassen</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

<?php
    $error_message = "";$success_message = "";
    //na aanpassen kaart
    if(isset($_POST['aanpassen'])){


    $aant_stemps= trim($_POST['stemps']);
    $label = trim($_POST['label']);
    $beschrijving = trim($_POST['beschrijving']);

    $klopt = true;

    // Check of alle velden ingevuld zijn
    if($aant_stemps == '' || $label == '' || $beschrijving == ''){
    $klopt = false;
    $error_message = "De velden mogen niet leeg zijn!";
   }

   // Als alles ingevuld is, query uitvoeren om in de database te plaatsen.
   if($klopt){
     $updateSQL = "UPDATE `stempelkaarten` SET `beloning_aantstemps`='".$aant_stemps."', `beloning_label`='".$label."', `beloning_beschrijving`='".$beschrijving."' WHERE `stempelkaart_id`='".$_GET['p']."'";
     $stmt = $con->prepare($updateSQL);
     $stmt->execute();
     $stmt->close();

     $success_message = "Uw stempelkaart is aangepast!</br>";
   }
}

    if(isset($_POST['delete'])){
     $deleteSQL = "DELETE FROM `stempelkaarten` WHERE `stempelkaarten`.`stempelkaart_id` ='".$_GET['p']."'";
     $stmt = $con->prepare($deleteSQL);
     $stmt->execute();
     $stmt->close();
     header('Location: ondernemer_kaartoverzicht.php?delete=1');
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
        <a href=""><i class="fas fa-user-circle"></i>Profiel</a>
        <a href="landing_ondernemer.php?x=uitloggen"><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
    </div>
<?php
 }
 ?>
</nav>
<div class="wrapper" style="overflow-x:auto;">

    <h1>Kaart aanpassen</h1>
    <table>
    <tr>

    </tr>
    </table>

        <form action="" method="post">
       <p><label for="stemps">Maximaal aantal stempels aanpassen (1-25):</label><br><input type="number" name="stemps" id="stemps"  min="1" max="25" value="<?php print $result_stemp->beloning_aantstemps; ?>" required> <br><br>
       <label for="label">Naam stempelkaart aanpassen:</label><input type="text" name="label" id="label" value="<?php print $result_stemp->beloning_label; ?>" required> <br>
       <label for="label">Beschrijving beloning aanpassen:</label><input type="text" name="beschrijving" id="beschrijving" value="<?php print $result_stemp->beloning_beschrijving; ?>" required max="400"> <br>
        <input type="submit" name="aanpassen" value="Pas kaart aan!">
        
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
        <button onclick="location.href='klant_koppelen.php?k=<?php print $_GET['p']; ?>&o=<?php print $_GET['o']; ?>';" id="btn_under">Koppel klant aan kaart!</button>
        </center>


       <form action="" method="post">
        <input type="submit" style="background-color:red;" name="delete" value="Verwijder kaart!">
        </form>

           <center>
        <button onclick="location.href='ondernemer_kaartoverzicht.php';" id="btn_under"><i class="fas fa-chevron-left"></i> Terug</button>
       </center>

         <h1></h1>
    </div>
        
        
        



</div>
</body>
</html>

<?php
	}
}
?>