<div id="enter">
<?php
if(isset($_SESSION['login']) && isset($_SESSION['password'])) echo "<p>{$ini_array['enter']['hello']} ".$_SESSION['login']."! <a href='exit.php'>{$ini_array['enter']['exit']}</a></p>";
else print "<a href='registration.php'>{$ini_array['enter']['registration']}</a>";
/*else print <<<HERE
<a href="login.php">{$ini_array['enter']['login']}</a> | <a href="registration.php">{$ini_array['enter']['registration']}</a>
HERE;*/
?>
</div>