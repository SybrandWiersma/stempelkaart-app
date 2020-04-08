<?php
include("config.php")

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Klant Registratie</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <?php 
    $error_message = "";$success_message = "";

    // Na registreren
   if(isset($_POST['registreer_k'])){

   $gebr_naam = trim($_POST['gebruikersnaam']);
   $wachtwoord = trim($_POST['wachtwoord']);
   $wachtwoord_h = trim($_POST['wachtwoord_h']);
   $naam = trim($_POST['naam']);
   $email = trim($_POST['email']);
   $telefoonnummer = trim($_POST['telefoonnummer']);

   //wachtwoord encoding
   $hash = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT, ['cost' => 5]);

   $klopt = true;

   // Check of alle velden ingevuld zijn
   if($gebr_naam == '' || $wachtwoord == '' || $wachtwoord_h == '' || $naam == '' || $email == '' || $telefoonnummer == ''){
     $klopt = false;
     $error_message = "Het is verplicht om alle velden in te vullen!";
   }

   // Check of de wachtwoorden exact hetzelfde zijn
   if($klopt && ($wachtwoord != $wachtwoord_h) ){
     $klopt = false;
     $error_message = "Wachtwoorden komen niet overeen";
   }

   // Check of er een ongeldig email adres ingevuld is
   if ($klopt && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
     $klopt = false;
     $error_message = "Vul een geldig email adres in.";
   }

      // Check of er een ongeldig Telefoonnummer ingevuld is
   if ($klopt && !preg_match('/^[0-9]{10}+$/', $telefoonnummer)) {
     $klopt = false;
     $error_message = "Vul een geldig telefoonnummer in (bijvoorbeeld: 0612345678).";
   }

     // Check of wachtwoord te kort is
   if ($klopt && strlen($wachtwoord) < 5) {
     $klopt = false;
     $error_message = "Het wachtwoord moet minimaal uit vijf  tekens bestaan.";
   }



   if($klopt){

     // Check of telefoonnummer al voorkomt in de database
     $stmt = $con->prepare("SELECT * FROM klanten WHERE tel_nr = ?");
     $stmt->bind_param("s", $telefoonnummer);
     $stmt->execute();
     $result = $stmt->get_result();
     $stmt->close();
     if($result->num_rows > 0){
       $klopt = false;
       $error_message = "Dit telefoonnummer is al bekend in ons systeem.</br>";
     }

    }
        if($klopt){

     // Check of email al voorkomt in de database
     $stmt = $con->prepare("SELECT * FROM klanten WHERE email = ?");
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $result = $stmt->get_result();
     $stmt->close();
     if($result->num_rows > 0){
       $klopt = false;
       $error_message = "Dit email adres is al bekend in ons systeem.</br>";
     }

   }

    if($klopt){

     // Check of gebruikersnaam al voorkomt in de database
     $stmt = $con->prepare("SELECT * FROM klanten WHERE gebr_naam = ?");
     $stmt->bind_param("s", $gebr_naam);
     $stmt->execute();
     $result = $stmt->get_result();
     $stmt->close();
     if($result->num_rows > 0){
       $klopt = false;
       $error_message = "Deze gebruikersnaam is al bekend in ons systeem.";
     }

   }

   // Als alles klopt, query uitvoeren om in de database te plaatsen.
   if($klopt){
     $insertSQL = "INSERT INTO `klanten`(`naam_klant`, `gebr_naam`, `wachtwoord`, `email`, `tel_nr`) VALUES (?,?,?,?,?)";
     $stmt = $con->prepare($insertSQL);
     $stmt->bind_param("sssss",$naam,$gebr_naam,$hash,$email,$telefoonnummer);
     $stmt->execute();
     $stmt->close();

     $success_message = "Uw account is aangemaakt!</br>";
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
        <h1><a href="">StempelkaartApp</a></h1>
        <a href=""><i class="fas fa-user-circle"></i>Profiel</a>
        <a href=""><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
    </div>
<?php
 }
 ?>
</nav>
<div class="wrapper">
    <h1>Registreren</h1>
    <form action="" method="post">

                        <?php 
            // Foutmelding
            if(!empty($error_message)){
            ?>
            
              <strong>Fout!  </strong> <?= $error_message ?> 
            

            <?php
            }
            ?>

            <?php 
            // Aanmaken gelukt
            if(!empty($success_message)){
            ?>
          
              <strong>Gelukt!</strong> <?= $success_message ?> 
           

            <?php
            }
            ?>
            <br>
        <input type="text" name="gebruikersnaam" id="gebruikersnaam" placeholder="Gebruikersnaam" required> <br>
        <input type="password" name="wachtwoord" id="wachtwoord" placeholder="Wachtwoord" required> <br>
        <input type="password" name="wachtwoord_h" id="wachtwoord_h" placeholder="Herhaal Wachtwoord" required> <br>
        <input type="text" name="naam" id="naam" placeholder="Naam" required> <br>
        <input type="email" name="email" id="email" placeholder="E-mail" required> <br>
        <input type="text" name="telefoonnummer" maxlength="10" id="telefoonnummer" placeholder="Telefoonnummer" required> <br>
        <input type="submit" name="registreer_k" value="Registreren">



        <button onclick="goBack()" id="btn_under"><i class="fas fa-chevron-left"></i> Terug</button>
<!--        Doet nog niks omdat er nog geen navigatie is-->
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
<!--        Doet nog niks omdat er nog geen navigatie is-->

    </form>
</div>

</body>
</html>