<?php
function showKaart($aant_stemps, $stemp_afb, $beloning_aantstemps)
{
    //for loop om vakken te weergeven MET stempel erin
    for ($i = 1;
         $i <= $aant_stemps;
         $i += 1) {

        if ($i == 6 || $i == 12 || $i == 18 || $i == 24 || $i == 25) {
            echo "<td width='15%'><img src='$stemp_afb' width='50px' heigth='50px'></td></tr><tr>";
        } else {
            echo "<td width='15%'><img src='$stemp_afb' width='50px' heigth='50px'></td>";
        }
    }

    //for loop om vakken te weergeven ZONDER stempel erin
    for ($x = 1;
         $x <= $beloning_aantstemps - $aant_stemps;
         $x += 1) {

        if ($x + $aant_stemps == 6 || $x + $aant_stemps == 12 || $x + $aant_stemps == 18 || $x + $aant_stemps == 24 || $x + $aant_stemps == 25) {
            echo "<td width=\"15%\" height=\"70px\"></td></tr><tr>";

        } else {
            echo "<td width=\"15%\" height=\"70px\"></td>";
        }
    }
}

function overzichtKaart($con, $result_aantal, $result_klant)
{

    $message = "";


    if ($result_aantal->num_rows < 1) {
        $message = "<h2>U bent nog niet gekoppeld aan een stempelkaart, neem contact op met het bedrijf!</h2>";
    }


    while ($result_pers = mysqli_fetch_object($result_aantal)) {

        //query om aantal gekoppelde kaarten te tellen
        $stmt = $con->prepare("SELECT * FROM stempelkaarten WHERE stempelkaart_id = ?");
        $stmt->bind_param("s", $result_pers->stempelkaart_id);
        $stmt->execute();
        $result_k = $stmt->get_result();
        $stmt->close();

        while ($result_kaart = mysqli_fetch_object($result_k)) {
            echo "<a href='klant_kaartweergeven.php?p=$result_pers->stempelkaart_id&o=$result_klant->klant_id'>
                <li class=\"Stempelkaart\">
                    <div id=\"ond_naam\">
                        <h2>$result_kaart->beloning_label</h2>
                    </div>
                    <div id=\"aant_stemp\">
                        <h2> $result_pers->aant_stemps
                            /$result_kaart->beloning_aantstemps</h2>
                    </div>
                </li>
            </a>";

        }
    }
    if (!empty($message)) {
        echo $message;
    }
}

function toonQR($p, $o, $klant_id, $stempelkaart_id)
{
    if (!isset($_GET['toon'])) {
        echo " <button onclick=location.href='klant_kaartweergeven.php?p=$p&o=$o&toon' id='btn_under'> Toon QR </button>";


    }

    if (isset($_GET['toon'])) {

        echo "<button onclick=location.href='klant_kaartweergeven.php?p=$p&o=$o' id='btn_under'> Verberg QR </button>";

        echo "<img src='https://chart.googleapis.com/chart?cht=qr&chl=klantid%3D$klant_id%26kaartid%3D$stempelkaart_id&choe=UTF-8&chs=400x400'>";


    }
}

function uploadStempel($gebruikersnaam)
{


    if (isset($_POST["submit2"])) {

        $uploadOk = 1;
        $target_dir = "images/uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload2"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = @getimagesize($_FILES["fileToUpload2"]["tmp_name"]);

        if ($check !== false) {
            $uploadOk = 1;
        } else
            // Sta alleen enkele typen afbeeldingen toe
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $bericht = "Sorry, alleen JPG, JPEG, PNG & GIF bestanden zijn toegestaan.";
                echo "<script type='text/javascript'>alert('$bericht');</script>";
                $uploadOk = 0;

            } else {
                $bericht = "U heeft iets anders dan een afbeelding geselecteerd.";
                echo "<script type='text/javascript'>alert('$bericht');</script>";
                $uploadOk = 0;

            }
        // Check of bestand al in de database voorkomt
        if (file_exists($target_file)) {
            $bericht = "Sorry, dit bestand bestaat al in onze database, geef het bestand een andere naam.";
            echo "<script type='text/javascript'>alert('$bericht');</script>";
            $uploadOk = 0;


        }


        if ($uploadOk != 0) {

            if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file)) {
                Update_ondernemer_stemp_afb_with_Gebrnaam($target_file, $gebruikersnaam);
                header("Refresh:0");


            } else {
                $bericht = "";

            }
        }

    }


}

function uploadLogo($gebruikersnaam)
{
    if (isset($_POST["submit"])) {

        $uploadOk = 1;
        $target_dir = "images/uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = @getimagesize($_FILES["fileToUpload"]["tmp_name"]);

        if ($check !== false) {
            $uploadOk = 1;
        } else
            // Sta alleen enkele typen afbeeldingen toe
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $bericht = "Sorry, alleen JPG, JPEG, PNG & GIF bestanden zijn toegestaan.";
                echo "<script type='text/javascript'>alert('$bericht');</script>";
                $uploadOk = 0;

            } else {
                $bericht = "U heeft iets anders dan een afbeelding geselecteerd.";
                echo "<script type='text/javascript'>alert('$bericht');</script>";
                $uploadOk = 0;

            }
        // Check of bestand al in de database voorkomt
        if (file_exists($target_file)) {
            $bericht = "Sorry, dit bestand bestaat al in onze database, geef het bestand een andere naam.";
            echo "<script type='text/javascript'>alert('$bericht');</script>";
            $uploadOk = 0;


        }


        if ($uploadOk != 0) {

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                Update_ondernemer_logo_with_Gebrnaam($target_file, $gebruikersnaam);
                header("Refresh:0");


            } else {
                $bericht = "";

            }
        }

    }
}

function getKaart($gebruikersnaam)
{

    // dmv iteratie nummer toevoegen aan elke stempelkaart
    $i = 1;

    //query om ondernemers_id uit de database op te halen
    $result_id = Get_ondernemer_with_Gebrnaam($gebruikersnaam);

    //query om kaarten uit de database op te halen, en dmv een lus dat voor elke kaart te doen
    $sql_kaart = Get_kaarten_with_ondID($result_id->ondernemer_id);
    while ($result_kaart = mysqli_fetch_object($sql_kaart)) {

        //query om aantal gekoppelde klanten te tellen
        $result = Get_link_with_kaartID($result_kaart->stempelkaart_id);


        echo "<tr>
                <td width='10%'>
                     $i
                    
                </td>
                <td width='30%'>

                    <a class='buttonnaam' style='background-color: #5cb85c'
                       href='ondernemer_kaartaanpassen.php?p=$result_kaart->stempelkaart_id&o=$result_id->ondernemer_id'>$result_kaart->beloning_label</a>
                </td>
                <td width='30%'>
                   $result_kaart->beloning_beschrijving
                </td>
                <td width='10%'>
                   $result->num_rows
                </td>
            </tr>";
        $i++;


    }
}

function showKaart_ond($beloning_aantstemps, $stemp_afb){

    for ($x = 1;
         $x <= $beloning_aantstemps;
         $x += 1){
        if ($x == 6 || $x == 12 || $x == 18 || $x == 24 || $x == 25){
            echo"
            <td width='15%' style='border-radius: 5px'>
                <img src='$stemp_afb' width='50px' height='50px'>
            </td>
            </tr>
            <tr>";

        } else {


            echo"<td width='15%' style='border-radius: 5px'>
                <img src='$stemp_afb' width='50px' height='50px'>
            </td>";



        }
    }
}



?>