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
<title><?=$ini_array['loginPage']['title']?></title>
<link href="css/style.css" type="text/css" rel="stylesheet"/>
</head>
<body>
    <div id="wrapper">
        <?php include("blocks/header.php")?>
        <?php include("blocks/menu.php")?>
        <div id="body">
            <div id="content">
<?php
if(isset($_SESSION['login'])) echo "<p>{$ini_array['loginPage']['you']}<span>".$_SESSION['login']."</span> (<a href='exit.php'>{$ini_array['loginPage']['exit']}</a>)</p>";
else{ print <<<HERE
    <h2>{$ini_array['loginPage']['h']}</h2>
    <form action="testreg.php" method="post">
        <p><label>{$ini_array['loginPage']['login']}<br/></label><input name="login" type="text" size="20" maxlength="20"/></p>
        <p><label>{$ini_array['loginPage']['password']}<br/></label><input name="password" type="password" size="20" maxlength="20"/></p>
        <p><input name="save" type="checkbox" value='1'/> Запомнить меня</p>
        <p><input type="submit" name="submit" value="{$ini_array['loginPage']['input']}"/></p>
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