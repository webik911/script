<?php
session_start();
if (isset($_GET['lang'])){ $_SESSION['lang'] = $_GET['lang'];}
elseif(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){ $_SESSION['lang'] = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));}
else { $_SESSION['lang'] = "ru";}

$ini_array = parse_ini_file("language/$_SESSION[lang].ini", true);
include ("blocks/db.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?=$ini_array['addPage']['title']?></title>
<link href="css/style.css" type="text/css" rel="stylesheet"/>
</head>
<body>
    <div id="wrapper">
        <?php include("blocks/header.php")?>
        <?php include("blocks/menu.php")?>
        <div id="body">
            <div id="content">
<?php

if(isset($_GET['id'])){
    include ("blocks/db.php");
    $delete = mysql_query("DELETE FROM data WHERE id='$_GET[id]'")
        or die("Invalid query: " . mysql_error());

    if($delete) echo "News removed.";
    else echo "Delete Error!";
}
else {echo "News not found";}
?>
            </div>
            <div id="right">
            <?php include("blocks/login_block.php")?>
            </div>
        </div>
        <?php include("blocks/footer.php")?>
    </div>

</body>
</html>