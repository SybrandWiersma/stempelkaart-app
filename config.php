<?php
$host		=	"localhost";					
$user		=	"root";				            
$pass		=	"";					           
$tablename	=	"stempelkaartapp";				

mysql_connect("$host","$user","$pass") && mysql_select_db("$tablename");

session_start();

if(isset($_SESSION['login'])){
    $dbresondernemer = mysql_query("SELECT * FROM `ondernemers` WHERE `gebr_naam`='{$_SESSION['login']}'");
    $dbresklant = mysql_query("SELECT * FROM `klanten` WHERE `gebr_naam`='{$_SESSION['login']}'");
    $data = mysql_fetch_object($dbresondernemer);
    $data2 = mysql_fetch_object($dbresklant);
    $_COOKIE['login'] = $_SESSION['login']
    $login = $_COOKIE['login'];

} else {
    unset($_SESSION['login']);
}

function check_login() {
    if(isset($_SESSION['login'])){
    return true;
    } else { 
    return false;
    }
}

?>
