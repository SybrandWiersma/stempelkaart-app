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
$session_value= $_SESSION['gebruikersnaam'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ondernemerspagina</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
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
            <a href="landing_ondernemer.php?x=uitloggen"><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
        </div>
        <?php
    }
    ?>
</nav>
<div class="wrapper">
    <h1>QR Scanner</h1>
    <div class="preview-container"><video style="align-content: center; width: 100%; padding: 5px;" id="preview"></video></div>
    <div class="preview-container">
    <h1>Scans</h1>
    <ul id="scans">

    </ul>
    </div>





</div>
<script>
    let sessionId = '<?php echo $session_value?>';
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    scanner.addListener('scan', function (content, image) {
        console.log(content);
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let node = document.createElement("LI");
                let v1 = document.createTextNode(this.responseText);
                node.appendChild(v1);
                document.getElementById("scans").appendChild(node);
            }
        };
        xmlhttp.open("POST", "checkscan.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("klant_id="+content+"&ondernemer_gebr_naam="+sessionId);

    });

    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        }
    });
</script>
</body>
</html>