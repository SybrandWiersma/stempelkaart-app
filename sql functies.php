// first_klant
SELECT  * FROM `klanten` WHERE `klant_id`='" . $_GET['x'] . "'

SELECT * FROM ondernemers WHERE gebr_naam = ?

SELECT * FROM klanten WHERE gebr_naam = ?

UPDATE `klanten` SET `wachtwoord`='" . $wachtwoord_n . "', `gebr_naam`='" . $gebruikersnaam . "' WHERE `klant_id`='" . $_GET['x'] . "'

//klant_gegevens
SELECT  * FROM klanten WHERE gebr_naam = ?

UPDATE klanten SET wachtwoord = ? WHERE gebr_naam = ?

//klant_kaartweergeven
SELECT  * FROM `klanten` WHERE `gebr_naam`='" . $_SESSION['klant'] . "'

SELECT  * FROM `stempelkaarten` WHERE `stempelkaart_id`='" . $_GET['p'] . "'

SELECT  * FROM `ondernemers` WHERE `ondernemer_id`='" . $result_stemp->ondernemer_id . "'

SELECT  * FROM `stempelkaart_klant` WHERE `stempelkaart_id`='" . $_GET['p'] . "'

//klant_registratie
SELECT * FROM klanten WHERE tel_nr = ?

SELECT * FROM klanten WHERE email = ?

SELECT * FROM klanten WHERE gebr_naam = ?

INSERT INTO `klanten`(`naam_klant`, `gebr_naam`, `wachtwoord`, `email`, `tel_nr`) VALUES (?,?,?,?,?)

//klant_stempelkaartoverzicht
SELECT  * FROM `klanten` WHERE `gebr_naam`='" . $_SESSION['klant'] . "'

SELECT * FROM stempelkaart_klant WHERE klant_id = ?")

SELECT  * FROM `stempelkaart_klant` WHERE `klant_id`='" . $result_klant->klant_id . "'

SELECT  * FROM `stempelkaarten` WHERE `stempelkaart_id`='" . $result_pers->stempelkaart_id . "'

//loginpagina
SELECT  * FROM `klanten` WHERE `klant_id`='" . $_GET['x'] . "'

select count(*) as cntUser_ondernemer from ondernemers where gebr_naam='" . $gebruikersnaam . "' and wachtwoord='" . $wachtwoord . "'

select count(*) as cntUser_klant from klanten where gebr_naam='" . $gebruikersnaam . "' and wachtwoord='" . $wachtwoord . "'

SELECT  * FROM `klanten` WHERE `gebr_naam`='" . $gebruikersnaam . "'

//ondernemer_gegevensbekijken
SELECT  * FROM `ondernemers` WHERE `gebr_naam`='" . $_SESSION['gebruikersnaam'] . "'

UPDATE `ondernemers` SET `wachtwoord`='" . $wachtwoord_n . "' WHERE `gebr_naam`='" . $_SESSION['gebruikersnaam'] . "'

SELECT * FROM ondernemers WHERE tel_nr = ?