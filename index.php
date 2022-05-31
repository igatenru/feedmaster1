<?php
include_once "inc/file_upload.inc.php";
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Загрузка фида</title>
</head>

<body>
<h1>Загрузка фида на сервер</h1>
    
<br>
<br>
<form enctype="multipart/form-data" method="post" action="converter.php">  
    <input type="hidden" name "MAX_FILE_SIZE" value="10000000" />
    <label>Выберите файл YML:</label>
    <input type="file" name="user_feed" />
    </br>
    </br>
    <input type="submit" name="uploadBtn" value="Загрузить YML файл" />
</form>


</body>
</html>