<?php
include("config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loginpage</title>
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
       <h1><a href="">StempelkaartApp</a></h1>
        <a href=""><i class="fas fa-user-circle"></i>Profiel</a>
        <a href=""><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
    </div>
<?php
 }
 ?>
</nav>
<div class="wrapper">
    <h1>Login</h1>
    <form action="" method="post">
        <label for="gebruikersnaam">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="gebruikersnaam" id="gebruikersnaam" placeholder="Gebruikersnaam" required> <br>
        <label for="Wachtwoord">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="wachtwoord" id="wachtwoord" placeholder="Wachtwoord" required> <br>
        <input type="submit" name="send" value="Inloggen">
        <button onclick="Terug()" id="btn_under"><i class="fas fa-chevron-left"></i> Terug</button>

        <!--<div class="nieuwhier">-->
        <!--    <h1>Nieuw Hier?</h1>-->
        <!--    <input type="button" id="btn_under" value="Registreren"/>-->
        <!--</div>-->
        <script>
            function Terug() {
                window.history.back();
            }
        </script>

<?php
if(isset($_POST['send'])){

    $gebruikersnaam = mysqli_real_escape_string($con,$_POST['gebruikersnaam']);
    $wachtwoord = mysqli_real_escape_string($con,$_POST['wachtwoord']);

    if ($gebruikersnaam != "" && $wachtwoord != ""){

        $sql_query_ondernemer = "select count(*) as cntUser_ondernemer from ondernemers where gebr_naam='".$gebruikersnaam."' and wachtwoord='".$wachtwoord."'";
        $result_ondernemer = mysqli_query($con,$sql_query_ondernemer);
        $row_ondernemer = mysqli_fetch_array($result_ondernemer);

        $sql_query_klant = "select count(*) as cntUser_klant from klanten where gebr_naam='".$gebruikersnaam."' and wachtwoord='".$wachtwoord."'";
        $result_klant = mysqli_query($con,$sql_query_klant);
        $row_klant = mysqli_fetch_array($result_klant);

        

        $count_ondernemer = $row_ondernemer['cntUser_ondernemer'];
        $count_klant = $row_klant['cntUser_klant'];


        if($count_ondernemer > 0){
            $_SESSION['gebruikersnaam'] = $gebruikersnaam;
            header('Location: home.php');
        }else{
            if($count_klant > 0){
                        $_SESSION['gebruikersnaam'] = $gebruikersnaam;
                        header('Location: home.php');
            } else {

            echo "De combinatie van gebruikersnaam en wachtwoord kwamen niet overeen!";
            }
        }

    }

}
?>
    </form>
</div>
</body>
</html>