<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_REQUEST['uploadBtn'])))
{
    $upload_dir = "feeds/";

    
    if (! empty($_POST['feed_url']))
    {
        
        $feed_url = htmlspecialchars($_POST['feed_url']);
        $file_name = basename($feed_url);

        if (file_put_contents("feeds/$file_name", file_get_contents($feed_url)))
        {
            echo "Фид успешно загружен";
        }
    }
    else
    { 
        $type = $_FILES['user_feed']['type'];
        $size = $_FILES['user_feed']['size'];
        $tmp = $_FILES['user_feed']['tmp_name'];
        $file_name = basename($_FILES['user_feed']['name']);
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
    }  

}    
?>