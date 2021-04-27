<?php

//грузим файл с оригинальным названием в папку feeds.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_REQUEST['uploadBtn']))) {
    $tmp = $_FILES['user_feed']['tmp_name'];
    $file_name = $_FILES['user_feed']['name'];
    move_uploaded_file($tmp, "feeds/$file_name");
}  
    
?>