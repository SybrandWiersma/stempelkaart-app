<?php
include("config.php")

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Beloning</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<nav class="navtop">
    <div>
        <h1>StempelkaartApp</h1>
        <a href=""><i class="fas fa-user-circle"></i>Profiel</a>
        <a href=""><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
    </div>
</nav>
<div class="wrapper">
    <h1>Snackbar Vette Hap</h1>
    <h2>Beloning</h2>
    <h4>Bij verzilvering van uw stempels krijgt u op uw volgende bestelling 10 euro korting</h4>
    <button onclick="goBack()" style="width: 40%; margin-bottom: 5%; margin-left: 30%"><i class="fas fa-chevron-left"></i> Terug</button>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>

</div>
</body>
</html>