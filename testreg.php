<?php
session_start();
if(isset($_POST['login'])) {$login = $_POST['login']; if ($login=='') {unset($login);}}
if(isset($_POST['password'])) {$password = $_POST['password']; if ($password=='') {unset($password);}}

if (empty($login) || empty($password)) exit ("You entered all the information, go back and fill in all fields!");

$login = htmlspecialchars(stripslashes(trim($login)));
$password = htmlspecialchars(stripslashes(trim($password)));
$password = md5($password);
$password = strrev($password);
if(preg_match("[^.+@.+\..+$]",$login) == 1) $email = $login;
include ("blocks/db.php");
$result = mysql_query("SELECT * FROM users WHERE password='$password' AND login='$login' OR email='$email'",$db)
    or die("Invalid query: " . mysql_error());
$myrow = mysql_fetch_array($result);

/*if($password == $myrow['password'] && ($login==$myrow['login'] || $login == $myrow['email'])){
    
}*/
if($result) {
    $_SESSION['password']=$myrow['password'];
    $_SESSION['login']=$myrow['login'];
    $_SESSION['email']=$myrow['email'];
    //exit("You register");
    echo "<html><head><meta http-equiv='Refresh' content='0; URL=index.php'></head></html>";
}
else exit ("Sorry, you entered an incorrect login or password.");
?>
