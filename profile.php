<?php
session_start();
if (isset($_GET['lang'])){ $_SESSION['lang'] = $_GET['lang'];}
elseif(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){ $_SESSION['lang'] = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));}
else { $_SESSION['lang'] = "ru";}

$ini_array = parse_ini_file("language/$_SESSION[lang].ini", true);
include ("blocks/db.php");
?>
<!DOCTYPE HTML PUBLIC "- / / W3C / / DTD XHTML 1.1 / / EN" "Http://www.w3.org/MarkUp/DTD/xhtml11.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?php print $ini_array['indexPage']['title'];?></title>
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
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $surname = htmlspecialchars(stripslashes($_POST['surname']));
    $email = htmlspecialchars(stripslashes($_POST['email']));
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $update = mysql_query("UPDATE users SET name='$name', surname='$surname', email='$email 'WHERE id=$id")
        or die("Invalid query: " . mysql_error());
    if ($update) echo "<p>Дание успешно обновлены.</p>";//exit("<html><head><meta    http-equiv='Refresh' content='0;    URL=index.php'></head></html>");
    else echo "<p>Дание не обновлены.</p>";
}
if(isset($_SESSION['login']) and isset($_SESSION['password'])){
    $login = $_SESSION['login'];
    $password = $_SESSION['password'];
    $result2 = mysql_query("SELECT id FROM users WHERE login='$login' AND password='$password'",$db)
        or die("Invalid query: " . mysql_error());
    $myrow2 = mysql_fetch_array($result2);
    if (empty($myrow2['id'])) { exit("Вход на эту страницу разрешен только зарегистрированным пользователям!");}

    $result = mysql_query("SELECT * FROM users WHERE id='$myrow2[id]'",$db)
        or die("Invalid query: " . mysql_error());
    $myrow = mysql_fetch_array($result);
    if (empty($myrow['id'])) { exit("Пользователя не существует! Возможно он был удален.");}

    if(!empty($_GET['par']) && $_GET['par']=='edit'){print <<<HERE
        <form action="$_SERVER[PHP_SELF]" method="post">
            <p><label>Edit name<br/><input name="name" type="text" size="20" maxlength="20" value="$myrow[name]"/></label></p>
            <p><label>Edit surname<br/><input name="surname" type="text" size="20" maxlength="20" value="$myrow[surname]"/></label></p>
            <p><label>Edit email<br/><input name="email" type="text" size="20" maxlength="20" value="$myrow[email]"/></label></p>
            <p><label>Edit avatar<br/><input type="FILE" name="avatar"></label></p>
            <p>The image must be in format jpg, gif or png.</p>
            <input name="id" type="hidden" value="$myrow[id]"/>
            <p><input type="submit" name="submit" value="Edit"/></p>
        </form>
HERE;
    }
    elseif(!empty($_GET['par']) && $_GET['par']=='del'){
        $delete = mysql_query("DELETE FROM users WHERE id='$_GET[id]'")
            or die("Invalid query: " . mysql_error());
            session_unset();

        if($delete) echo "<p>User deleted.</p>";
        else echo "<p>Delete Error!</p>";
    }
    else {
        echo "<h2>Your status</h2>";
        print "<img src='users/webik/avatar/default1.jpg'/><br/>";
        if(!empty($myrow['name'])){echo "<p>Your name: $myrow[name]</p>";}
        if(!empty($myrow['surname'])){echo "<p>Your surname: $myrow[surname]</p>";}
        if(!empty($myrow['login'])){echo "<p>Your login: $myrow[login]</p>";}
        if(!empty($myrow['email'])){echo "<p>Your email: $myrow[email]</p>";}
        if(!empty($myrow['date'])){echo "<p>Registered: $myrow[date]</p>";}
        echo "<div class='clear'></div>";
        echo "<a href='profile.php?par=edit&id=$myrow[id]'>Edit</a> | <a href='profile.php?par=del&id=$myrow[id]'>Delete</a>";
    }
}
else {exit("Вход на эту страницу разрешен только зарегистрированным пользователям!");}
?>
            </div>

            <div id="right">
            <?php include("blocks/login_block.php")?>
            <?php include("blocks/number.php")?>
            </div>
        </div>
        <?php include("blocks/footer.php")?>
    </div>

</body>
</html>