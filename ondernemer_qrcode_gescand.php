<?php
include("config.php");

// Check of gebruiker ingelogd is of niet
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: index.php');
}
// Uitloggen (eerste check of er een 'x' in de browser meegegeven wordt, zoja als dat uitloggen is word je uitgelogd)
if (isset($_GET['x'])) {
    if ($_GET['x'] == "uitloggen") {
        session_destroy();
        header('Location: index.php');
    }
}


// Haalt de ondernemer id uit de database met de gebruikersnaam uit de sessie
$query_ondernemingID = "SELECT ondernemer_id FROM ondernemers WHERE gebr_naam = '".$_SESSION['gebruikersnaam']."';";
$result_ondernemingID = mysqli_query($con, $query_ondernemingID);
$row_ondernemingID = mysqli_fetch_array($result_ondernemingID);

// Haalt de klant id en kaart id op die mee gegeven zijn met de pagina
$ondernemer_id = $row_ondernemingID['ondernemer_id'];
$klant_id = $_GET['klantid'];
$kaart_id = $_GET['kaartid'];

// Als er niets is mee gegeven word de error pagina weergeven
if(!isset($klant_id) && !isset($kaart_id)){
    header('Location: 404.php');
}

// Checkt of de klant een kaart heeft bij de ondernemer zodat een ondernemer niet bij klanten van andere ondernemers kan
$query_check_koppeling = "SELECT * FROM stempelkaarten WHERE ondernemer_id ='".$ondernemer_id."' AND stempelkaart_id ='".$kaart_id."';";
$result_check_koppeling = mysqli_query($con, $query_check_koppeling);
if(mysqli_num_rows($result_check_koppeling) == 0){
    header('Location: 404.php');
}
$row_kaartdata = mysqli_fetch_array($result_check_koppeling);

// Haalt de klant data op met klant id
$query_klantdata = "SELECT * FROM klanten WHERE klant_id ='".$klant_id."';";
$result_klantdata = mysqli_query($con, $query_klantdata);
$row_klantdata = mysqli_fetch_array($result_klantdata);

// Haalt het aantal stempels op dat de klant heeft
$query_aantstemps = "SELECT * FROM stempelkaart_klant WHERE klant_id ='".$klant_id."'AND stempelkaart_id = '".$kaart_id."';";
$result_aantstemps = mysqli_query($con, $query_aantstemps);
$row_aantstemps = mysqli_fetch_array($result_aantstemps);

// checkt of de ondernemer een aanvraag heeft gedaan om stempels toe te voegen
if (isset($_POST['stempelzetten']) && isset($_POST['stempel_aantal'])) {

    // Checkt of het aantal toe te voegen stempels niet groter is dan het aantal dat je kan toevoegen
    if ($_POST['stempel_aantal'] > ($row_kaartdata['beloning_aantstemps'] - $row_aantstemps['aant_stemps'])|| $_POST['stempel_aantal'] <= 0) {
        header('Location: 404.php');
    }

    // berekent het nieuwe stempel aantal
    $aantal_toevoegen = $_POST['stempel_aantal'] + $row_aantstemps['aant_stemps'];

    // Update het stempelaantal in database
    $stempels_toevoegen_query = "UPDATE stempelkaart_klant SET aant_stemps = ? WHERE klant_id = ? AND stempelkaart_id = ?";
    $stmt = $con->prepare($stempels_toevoegen_query);
    $stmt->bind_param('sss', $aantal_toevoegen, $klant_id, $kaart_id);
    $stmt->execute();
    $stmt->close();

    // Update de stempel waarden zodat deze goed word weergeven op de pagina
    $result_aantstemps = mysqli_query($con, $query_aantstemps);
    $row_aantstemps = mysqli_fetch_array($result_aantstemps);

    // Zorgt er voor dat er een upate message word weergeven
    $stempeltoegevoegdmessage = "stempel(s) toegevoegd";
}

// Checkt of de ondernemer een kaart wil verzilveren
if (isset($_POST['kaartverzilveren'])){
    // Checkt of de kaart daadwerkelijk vol is
    if (!($row_aantstemps['aant_stemps'] == $row_kaartdata['beloning_aantstemps'])){
        header('Location: 404.php');
    }
    // Verzilvert de kaart in de database dus zet stempelaantal op 0
    $stempelkaart_verzilveren_query = "UPDATE stempelkaart_klant SET aant_stemps = 0 WHERE klant_id = ? AND stempelkaart_id = ?";
    $stmt = $con->prepare($stempelkaart_verzilveren_query);
    $stmt->bind_param('ss', $klant_id, $kaart_id);
    $stmt->execute();
    $stmt->close();

    // Update de stempel waarden zodat deze goed word weergeven op de pagina
    $result_aantstemps = mysqli_query($con, $query_aantstemps);
    $row_aantstemps = mysqli_fetch_array($result_aantstemps);

    // Zorgt er voor dat er een upate message word weergeven
    $stempelkaartverzilverdmessage = "stempelkaart verzilverd";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR-code Informatie</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<nav class="navtop">
    <?php
    //check of gebruiker niet ingelogd is, dan weergeef je de registratie links en inlog link
    if(!isset($_SESSION['gebruikersnaam'])){

        ?>

        <div>
            <h1><a href="index.php">StempelkaartApp</a></h1>
            <a href="ondernemer_registeren.php"><i class="fas fa-user-circle"></i>Registreren als ondernemer</a>
            <a href="klant_registratie.php"><i class="fas fa-user-circle"></i>Registreren als klant</a>
            <a href="loginpagina.php"><i class="fas fa-sign-out-alt"></i>Inloggen</a>
        </div>
        <?php
        //wanneer gebruiker wel ingelogd is weergeef je de links naar profiel en uitlog knop
    } else {
        ?>
        <div>
            <h1><a href="ondernemer_landing.php">StempelkaartApp</a></h1>
            <a href="ondernemer_gegevensbekijken.php"><i class="fas fa-user-circle"></i>Profiel</a>
            <a href="ondernemer_landing.php?x=uitloggen"><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
        </div>
        <?php
    }
    ?>
</nav>
<div class="wrapperQRinfo">
    <h1>QR-Code Informatie</h1>

    <h4>Naam</h4> <p><?php echo $row_klantdata['naam_klant']?></p>
    <h4>Aantal stempels</h4> <p><?php echo $row_aantstemps['aant_stemps']." / ".$row_kaartdata['beloning_aantstemps']?></p>
    <h4>Beloning</h4><p><?php echo $row_kaartdata['beloning_label']?></p>


    <form action="ondernemer_qrcode_gescand.php?kaartid=<?php echo$kaart_id?>&klantid=<?php echo$klant_id?>" method="post">
    <h4>Stempels Toevoegen</h4> <input type="number" name="stempel_aantal" value="0" min="1" max="<?php echo $row_kaartdata['beloning_aantstemps'] - $row_aantstemps['aant_stemps'] ?>"> <!--max moet resterend aantal stempels zijn!-->
    <div style="border-bottom: 1px solid #dee0e4"></div>
    <button <?php if ($row_aantstemps['aant_stemps'] == $row_kaartdata['beloning_aantstemps'])echo "style =\"background-color:#4d5563; opacity:50%\" disabled"?> name="stempelzetten" type="submit">Stempel(s) Zetten</button>
        <?php if(isset($stempeltoegevoegdmessage)) echo "<br><br>".$stempeltoegevoegdmessage."<br>"?>
    </form>


    <form action="ondernemer_qrcode_gescand.php?kaartid=<?php echo$kaart_id?>&klantid=<?php echo$klant_id?>" method="post">
    <button <?php if($row_aantstemps['aant_stemps'] != $row_kaartdata['beloning_aantstemps']) echo "style =\"background-color:#4d5563; opacity:50%\" disabled";?> name="kaartverzilveren" type="submit" >Kaart Verzilveren</button>
    <?php if(isset($stempelkaartverzilverdmessage)) echo "<br><br>".$stempelkaartverzilverdmessage."<br>"?>
    </form>

    <form action="ondernemer_qrcode_gescand.php?kaartid=<?php echo$kaart_id?>&klantid=<?php echo$klant_id?>" method="post">
        
    <button name="kaartwijzigen" value="2">Kaart Wijzigen</button>


    <div style="border-bottom: 1px solid #dee0e4"></div>

    <button onclick="goBack()" style="width: 40%; margin-bottom: 5%"><i class="fas fa-chevron-left"></i> Terug</button> <br>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</div>

</body>
</html>