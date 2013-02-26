<?php
session_start();
if (isset($_GET['lang'])){ $_SESSION['lang'] = $_GET['lang'];}
elseif(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){ $_SESSION['lang'] = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));}
else { $_SESSION['lang'] = "ru";}

$ini_array = parse_ini_file("language/$_SESSION[lang].ini", true);
include ("blocks/db.php");
if(isset($_GET['id'])){
    $result = mysql_query("SELECT * FROM data WHERE id='$_GET[id]'",$db)
                    or die("Invalid query: " . mysql_error());
    $myrow = mysql_fetch_array($result);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?=$ini_array['editPage']['title']?></title>
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
    $title = htmlspecialchars(stripslashes($_POST['title']));
    $text = htmlspecialchars(stripslashes($_POST['text']));
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $update = mysql_query("UPDATE data SET title='$title', text='$text' WHERE id=$id")
        or die("Invalid query: " . mysql_error());
    if ($update) echo "<p>{$ini_array['editPage']['message_yes']}</p><br/>";//exit("<html><head><meta    http-equiv='Refresh' content='0;    URL=index.php'></head></html>");
    else echo "{$ini_array['editPage']['message_no']}";
}
elseif(isset($_GET['par'])=='edit'){
    print <<<HERE
    <form action="$_SERVER[PHP_SELF]" method="POST">
        <p><label>{$ini_array['addPage']['name']}<br/><input name="title" type="text" value="$myrow[title]"/></label></p>
        <p><label>{$ini_array['addPage']['text']}<br/><textarea name="text">$myrow[text]</textarea></label></p>
        <input name="id" type="hidden" value="$_GET[id]"/>
        <input type="submit" value='{$ini_array['editPage']['input']}'/>
    </form>
        
HERE;
}
elseif(isset($_GET['id'])){
    print <<<HERE
    <div class="data">
        <h2>$myrow[title]</h2>
        <div class='desc'>
            <p>$myrow[text]</p>
        </div>
        <p>{$ini_array['editPage']['date']}<span>$myrow[date]</span></p>
        <p>{$ini_array['editPage']['author']}<span>$myrow[author]</span></p>
HERE;
    if($myrow['author']==$_SESSION['login']) echo "<a href='view.php?par=edit&id=$_GET[id]'>{$ini_array['editPage']['edit']}</a> | <a href='delete.php?id=$_GET[id]'>{$ini_array['editPage']['delete']}</a>";
print <<<HERE
        <div class='bg'></div>
    </div>
HERE;
}
else {
    $result2 = mysql_query("SELECT id,title,date,author FROM data ORDER BY date DESC",$db)
                    or die("Invalid query: " . mysql_error());
    $myrow2 = mysql_fetch_array($result2);
    do {
    $description = implode(array_slice(explode('<br/>',wordwrap($myrow2['text'],30,'<br/>\n',false)),0,1)).'...';
        printf("<div class='data'>
            <h2><a href='view.php?id=%s'>%s</a></h2>
            <p>%s</p>
            <p>{$ini_array['editPage']['date']}<span>%s</span></p>
            <p>{$ini_array['editPage']['author']}<span>%s</span></p>
            <a href='view.php?id=%s'>Read More</a>
            <div class='bg'></div>
        </div>",$myrow2['id'],$myrow2['title'],$description,$myrow2['date'],$myrow2['author'],$myrow2['id']);
    }
    while($myrow2 = mysql_fetch_array($result2));
}
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