<?php
if(empty($_SESSION['login'])) { print <<<HERE
    <h2>{$ini_array['loginPage']['h']}</h2>
    <form action="testreg.php" method="post">
        <p><label>{$ini_array['loginPage']['login']}<br/></label><input name="login" type="text" size="20" maxlength="20"/></p>
        <p><label>{$ini_array['loginPage']['password']}<br/></label><input name="password" type="password" size="20" maxlength="20"/></p>
        <p><input type="submit" name="submit" value="{$ini_array['loginPage']['input']}"/></p>
    </form>
    <div class="bg"></div>
HERE;
}
?>