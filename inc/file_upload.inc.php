<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_REQUEST['uploadBtn'])))
{
    $type = $_FILES['user_feed']['type'];
    $size = $_FILES['user_feed']['size'];
    $tmp = $_FILES['user_feed']['tmp_name'];
    $file_name = basename($_FILES['user_feed']['name']);
    $upload_dir = "feeds/";
    $whitelist = array("xml", "yml");
    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

    if (! in_array($file_extension, $whitelist))
    {
        echo "Загружен файл неверного формата $file_extension</br></br>" . "Загрузите .xml файл";
        exit;
    }
    else
    {
        /* if ($type != "text/xml" || $type != "application/xml")
        {
            echo "Загружен файл неверного формата" . PHP_EOL . "Загрузите .xml файл";
        }
        else
        { */
            if ($size > 100000000)
            {
                echo "Загружен файл слишком большого размера. Допустимый размер: до 100 Мб.";
                exit;
            }
            else
            {
                if (!is_writable($upload_dir))
                {
                    echo "Папка " . $upload_dir . " не имеет прав на запись";
                    exit;
                }
                else
                {
                    $copy_file = copy($tmp, ($upload_dir . $file_name));
                    if (! $copy_file)
                    {
                       echo "Возникла ошибка, файл не удалось загрузить!";
                       exit;
                    }
                    else
                    {
                        chmod(($upload_dir . $file_name), 0644);
                        echo "Файл успешно загружен!";
                    }
                }
            }
        //}
    }



    /*
    chmod("$tmp/$file_name", 0644);
    move_uploaded_file($tmp, "feeds/$file_name");
    chmod("feeds/$file_name", 0644);
    */
}  
    
?>