<?php
include("config.php");
require("header_login.php");

$message = "";

if (isset($_GET['p'])) {
    if ($_GET['p'] == "aangepast") {
        $message = "U heeft uw automatische wachtwoord al aangepast, log in met uw gegevens";
    } else if ($_GET['p'] == "gelukt") {
        $message = "U heeft uw automatische wachtwoord aangepast, log in met uw gegevens";
    }
}
?>

<div class="wrapper">
    <h1>Login</h1>
    <form action="" method="post">
        <?php
        if (!empty($message)) {
            echo $message;
        }

        if (isset($_GET['x'])) {

            //query om gegevens klant uit de database op te halen
            $sql_klant = "SELECT  * FROM `klanten` WHERE `klant_id`='" . $_GET['x'] . "'";
            $sql_query_klant = mysqli_query($con, $sql_klant);
            $result_klant = mysqli_fetch_object($sql_query_klant);


            if ($result_klant->wachtwoord == "12345") {
                header('Location:  first_klant.php?x=' . $_GET['x']);
            }
        }
        ?>
        <label for="gebruikersnaam">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="gebruikersnaam" id="gebruikersnaam" placeholder="Gebruikersnaam" required> <br>
        <label for="wachtwoord">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="wachtwoord" id="wachtwoord" placeholder="Wachtwoord" required> <br>
        <input type="submit" name="send" value="Inloggen">
        <button onclick="Terug()" id="btn_under"><i class="fas fa-chevron-left"></i> Terug</button>


        <script>
            function Terug() {
                window.history.back();
            }
        </script>
        <h1></h1>

        <?php
        if (isset($_POST['send'])) {

            $gebruikersnaam = mysqli_real_escape_string($con, $_POST['gebruikersnaam']);
            $wachtwoord = mysqli_real_escape_string($con, $_POST['wachtwoord']);

            if ($gebruikersnaam != "" && $wachtwoord != "") {

                $sql_query_ondernemer = "select count(*) as cntUser_ondernemer from ondernemers where gebr_naam='" . $gebruikersnaam . "' and wachtwoord='" . $wachtwoord . "'";
                $result_ondernemer = mysqli_query($con, $sql_query_ondernemer);
                $row_ondernemer = mysqli_fetch_array($result_ondernemer);

                $sql_query_klant = "select count(*) as cntUser_klant from klanten where gebr_naam='" . $gebruikersnaam . "' and wachtwoord='" . $wachtwoord . "'";
                $result_klant = mysqli_query($con, $sql_query_klant);
                $row_klant = mysqli_fetch_array($result_klant);


                $count_ondernemer = $row_ondernemer['cntUser_ondernemer'];
                $count_klant = $row_klant['cntUser_klant'];


                if ($count_ondernemer > 0) {
                    $_SESSION['gebruikersnaam'] = $gebruikersnaam;
                    header('Location: ondernemer_landing.php');
                } else {
                    if ($count_klant > 0) {
                        if ($wachtwoord == "12345") {
                            $sql_klant = "SELECT  * FROM `klanten` WHERE `gebr_naam`='" . $gebruikersnaam . "'";
                            $sql_query_klant = mysqli_query($con, $sql_klant);
                            $result_klant = mysqli_fetch_object($sql_query_klant);

                            header('Location:  first_klant.php?x=' . $result_klant->klant_id);
                        } else {
                            $_SESSION['klant'] = $gebruikersnaam;
                            header('Location: klant_stempelkaartoverzicht.php');
                        }
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