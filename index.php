<?php
include_once "inc/file_upload.inc.php";
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Конвертор товарных фидов YML в формат Google и Facebook</title>
</head>

<body>
<h1>Конвертор товарных фидов YML (Yandex) в формат Google</h1>
<p>Конвертирует <a href="https://yandex.ru/support/marketplace/assortment/auto/yml.html" target="_blanc">товарный фид Яндекса (YML)</a>
в фид формата Google (такой же использует Facebook и Instagram). Автоматически добавляет недостающие секции, корректно устанавливает oldprice (со сроком акции)
делает улучшение названия товара, где это возможно.</p>   
<br>
<br>
<form enctype="multipart/form-data" method="post" action="converter.php">  
    <input type="hidden" name "MAX_FILE_SIZE" value="100000000" />
    <label>Выберите файл YML:</label></br></br>
    <input type="file" name="user_feed" /></br></br>
    <label>Или укажите ссылку на фид:</label></br></br>
    <input type="url" name="feed_url" />
    </br>
    </br>
    <input type="submit" name="uploadBtn" value="Конвертировать в Google XML" />
</form>


</body>
</html>