<?php
$host		=	"localhost";					
$user		=	"root";				            
$pass		=	"";					           
$tablename	=	"stempelkaartapp";				

mysql_connect("$host","$user","$pass") && mysql_select_db("$tablename");

session_start();

if(isset($_SESSION['gebruikersnaam'])){
    $dbresondernemer = mysql_query("SELECT * FROM `ondernemers` WHERE `gebr_naam`='{$_SESSION['gebruikersnaam']}'");
    $dbresklant = mysql_query("SELECT * FROM `klanten` WHERE `gebr_naam`='{$_SESSION['gebruikersnaam']}'");
    $data = mysql_fetch_object($dbresondernemer);
    $data2 = mysql_fetch_object($dbresklant);
    $_COOKIE['gebruikersnaam'] = $_SESSION['gebruikersnaam']
    $login = $_COOKIE['gebruikersnaam'];

} else {
    unset($_SESSION['gebruikersnaam']);
}

function check_login() {
    if(isset($_SESSION['gebruikersnaam'])){
    return true;
    } else { 
    return false;
    }
}

function passcheck($wachtwoord, $login)
{	
	
	global $variabele;
	$md5 = md5($variabele);
	$sec_ww = strip_tags($wachtwoord);
	$sec_ww = htmlentities($sec_ww);
	$sec_ww = mysql_real_escape_string($sec_ww);
	$pass = md5($sec_ww.$variabele);
	$arr1 = str_split($pass, 8);
	$arr2 = str_split($md5, 8);
	$hashww = $arr2['0'].$arr1['1'].$arr1['0'].$arr2['3'].$arr2['1'].$arr1['2'].$arr2['2'].$arr1['3'];
	$login_new = strip_tags ($login);
  	$login1 = ( $login_new );
	$realpass = hash('sha512', $hashww);
  	$dblogintest_ondernemer = mysql_query ( "SELECT * FROM ondernemers WHERE gebr_naam = '" . mysql_real_escape_string ( $login1 ) . "' AND wachtwoord = '" . mysql_real_escape_string ( $realpass ) . "'" );
	$loginbestaat_ondernemer = mysql_num_rows($dblogintest_ondernemer);
  	$dblogintest_klant = mysql_query ( "SELECT * FROM klanten WHERE gebr_naam = '" . mysql_real_escape_string ( $login1 ) . "' AND wachtwoord = '" . mysql_real_escape_string ( $realpass ) . "'" );
	$loginbestaat_klant = mysql_num_rows($dblogintest_klant);
	if($loginbestaat_ondernemer > 0){
	return TRUE;
	} else if($loginbestaat_ondernemer < 1){
		if($loginbestaat_klant > 0){
		return TRUE;
		} else if($loginbestaat_klant < 1){
		return FALSE;
		} else {
	return FALSE;
		}
	}
}

?>
