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
<title><?php print $ini_array['regPage']['title'];?></title>
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
    $login = htmlspecialchars(stripslashes(trim($_POST['login'])));
    $password1 = htmlspecialchars(stripslashes(trim($_POST['password1'])));
    $password2 = htmlspecialchars(stripslashes(trim($_POST['password2'])));
    $email = htmlspecialchars(stripslashes(trim($_POST['email'])));
    
    if(strlen($login)<4 || strlen($login)>20) echo "Username can not consist of less than 4 characters and more than 20";
    elseif(strlen($password1)<4 || strlen($password1)>20) echo "Password can not contain less than 4 characters and more than 20";
    elseif($password1 != $password2) echo "Passwords do not match";
    elseif(preg_match("[^.+@.+\..+$]",$email) == 0) echo "You have entered incorrect e-mail.";

    $password1 = md5($password1);          
    $password1 = strrev($password1);

    $resultL = mysql_query("SELECT id FROM users WHERE login='$login' or email='$email'",$db);
    $myrowL = mysql_fetch_array($resultL);
    
    if (!empty($myrowL['id'])) echo "Sorry, the username you entered is already registered. Enter a different username.";
    else {
        $result2 = mysql_query ("INSERT INTO users (login,password,email) VALUES('$login','$password1','$email')");
        if ($result2) {
            echo "<p>{$ini_array['regPage']['you']}";/*<a href='login.php'>{$ini_array['regPage']['login']}</a>{$ini_array['regPage']['site']}</p>*/
            $_SESSION['password']=$password1;
            $_SESSION['login']=$login;
            $_SESSION['email']=$email;
            echo "<html><head><meta http-equiv='Refresh' content='0; URL=index.php'></head></html>";
        }
        else echo "Error! You are not registered.";
    }
}
else{ print <<<HERE
    <h2>{$ini_array['regPage']['h']}</h2>
    <form action="$_SERVER[PHP_SELF]" method="post">
        <p><label>{$ini_array['regPage']['login']}<br/></label><input name="login" type="text" size="20" maxlength="20"/></p>
        <p><label>{$ini_array['regPage']['pas1']}<br/></label><input name="password1" type="password" size="20" maxlength="20"/></p>
        <p><label>{$ini_array['regPage']['pas2']}<br/></label><input name="password2" type="password" size="20" maxlength="20"/></p>
        <p><label>{$ini_array['regPage']['email']}<br/></label><input name="email" type="text" size="20" maxlength="20"/></p>
        <p><input type="submit" name="submit" value="{$ini_array['regPage']['input']}"/></p>
    </form>
HERE;
}
?>
            </div>
            <div id="right">
                <?php include("blocks/number.php")?>
                <?php include("blocks/login_block.php")?>
            </div>
        </div>
        <?php include("blocks/footer.php")?>
    </div>

</body>
</html>