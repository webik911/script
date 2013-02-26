<?php
    $users = mysql_query("SELECT COUNT(*) FROM users"); 
    $users = mysql_fetch_array($users);
?>
<p><?=$ini_array['number']['users'].$users['0']?></p>
<div class='bg'></div>