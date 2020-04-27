<?php
include("config.php");
require("header_ondernemer.php");

// Gebruikersnaam opslaan in variabele zodat js hem kan gebruiken
$session_value = $_SESSION['gebruikersnaam'];
?>

<div class="wrapper">
    <h1>QR Scanner</h1>
    <div class="preview-container">
        <video style="align-content: center; width: 100%; padding: 5px;" id="preview"></video>
    </div>
    <div class="preview-container">
        <h1>Scans</h1>
        <ul id="scans">
        </ul>
    </div>

    <br/>
    <button onclick="location.href='ondernemer_landing.php';" id="btn_under"><i class="fas fa-chevron-left"></i> Terug
    </button>
    <h1></h1>


</div>
<script>
    let sessionId = '<?php echo $session_value?>';
    let scanner = new Instascan.Scanner({video: document.getElementById('preview')});

    scanner.addListener('scan', function (content, image) {
        console.log(content);
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let parser = new DOMParser();
                let v1 = parser.parseFromString(this.responseText, "text/html");
                let v2 = v1.getElementsByTagName('li');
                document.getElementById("scans").appendChild(v2[0]);
            }
        };
        xmlhttp.open("POST", "ondernemer_qrchecker.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(content + "&ondernemer_gebr_naam=" + sessionId);

    });

    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        }
    });
</script>
</body>
</html>