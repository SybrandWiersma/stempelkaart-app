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
    let sessionId = '<?php echo $_SESSION["gebruikersnaam"]?>';
    xmlhttp.open("GET", "checkscan.php?scan="+content+"&gebrid="+sessionId, true);
    xmlhttp.send();

});

Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
        scanner.start(cameras[0]);
    }
});
