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
if($_SESSION['login']=='admin') echo "<p>{$ini_array['indexPage']['hello']} ".$_SESSION['login']."! {$ini_array['indexPage']['you']} <a href='add_news.php'>{$ini_array['indexPage']['add']}</a> {$ini_array['indexPage']['news']}.</p><div class='bg'></div>";
if(empty($_SESSION['login'])) echo "<p>{$ini_array['indexPage']['guest']}</p><div class='bg'></div>";
    $result2 = mysql_query("SELECT * FROM data ORDER BY date DESC",$db)
        or die("Invalid query: " . mysql_error());
    $myrow2 = mysql_fetch_array($result2);
    
    do {
        $description = implode(array_slice(explode('<br/>',wordwrap($myrow2['text'],150,'<br/>',false)),0,1)).'...';
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