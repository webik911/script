<?php
$db =mysql_connect("localhost", "root", "123qwe")
        or die("Could not connect: " . mysql_error());
mysql_select_db('script', $db) or die ('Can\'t use script : ' . mysql_error());
?>