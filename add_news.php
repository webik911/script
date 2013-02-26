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
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = htmlspecialchars(stripslashes($title));
    $text = htmlspecialchars(stripslashes($text));
    
    $sql = "INSERT INTO data(title,author,text) VALUES ('$_POST[title]','$_SESSION[login]','$_POST[text]')";
    $result = mysql_query($sql)
        or die("Invalid query: " . mysql_error());
    
if ($result=='TRUE') echo "<p>{$ini_array['addPage']['message_yes']}</p>";//exit("<html><head><meta    http-equiv='Refresh' content='0;    URL=index.php'></head></html>");
else echo "<p>{$ini_array['addPage']['message_no']}</p>";
}
else{ print <<<HERE
    <form action="$_SERVER[PHP_SELF]" method="POST">
        <p><label>{$ini_array['addPage']['name']}<br/><input name="title" type="text"/></label></p>
        <p><label>{$ini_array['addPage']['text']}<br/><textarea name="text"></textarea></label></p>
        <input type="submit" value="{$ini_array['addPage']['input']}"/>
    </form>
HERE;
}
?>
            </div>
            <div id="right"><?php include("blocks/number.php")?><div class="bg"></div></div>
        </div>
        <?php include("blocks/footer.php")?>
    </div>

</body>
</html>