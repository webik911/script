<?php
session_start();
if (isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
    setcookie("lang",$_GET['lang'], time()+99999);
}
elseif (isset($_COOKIE['lang']))
    $_SESSION['lang'] = $_COOKIE['lang'];
elseif(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
    $_SESSION['lang'] = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
else
    $_SESSION['lang'] = "ru";

if(!empty($_COOKIE['auto']) && $_COOKIE['auto'] == "yes"){
    $_SESSION['id'] = $_COOKIE['id'];
    $_SESSION['login'] = $_COOKIE['login'];
    $_SESSION['password'] = $_COOKIE['password'];
}
include ("blocks/db.php");
$ini_array = parse_ini_file("language/$_SESSION[lang].ini", true);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?=$ini_array['about']['title']?></title>
<link href="css/style.css" type="text/css" rel="stylesheet"/>
</head>
<body>
    <div id="wrapper">
        <?php include("blocks/header.php")?>
        <?php include("blocks/menu.php")?>
        <div id="body">
            <div id="content">
                <p><?=$ini_array['about']['text']?></p>
            <div class="bg"></div>
            </div>

            <div id="right"><?php include("blocks/number.php")?><div class="bg"></div></div>
        </div>
        <?php include("blocks/footer.php")?>
    </div>

</body>
</html>