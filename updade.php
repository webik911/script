<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = htmlspecialchars(stripslashes($_POST['title']));
    $text = htmlspecialchars(stripslashes($_POST['text']));
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $update = mysql_query("UPDATE data SET title='$title', text='$text' WHERE id='$id'")
        or die("Invalid query: " . mysql_error());
    if ($update) echo "<p>{$ini_array['editPage']['message_yes']}</p><br/>";//exit("<html><head><meta    http-equiv='Refresh' content='0;    URL=index.php'></head></html>");
    else echo "{$ini_array['editPage']['message_no']}";
}