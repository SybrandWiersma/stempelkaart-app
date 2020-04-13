let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
scanner.addListener('scan', function (content, image) {
    console.log(content);
    let node = document.createElement("LI");
    node.style.listStyle = "none";
    node.style.border = "1px solid black";
    node.style.borderRadius = "5px";
    node.style.marginRight = "10%";
    node.style.marginTop = "10%";
    node.style.padding = "4%";
    let v1 = document.createTextNode(content);
    node.appendChild(v1);
    document.getElementById("scans").appendChild(node);

});

Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
        scanner.start(cameras[0]);
    }
});