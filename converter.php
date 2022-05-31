<html>
<head>
	<meta charset="utf-8">
	<title>Результат конвертирования</title>
</head>

<body>

<?php

include_once "inc/file_upload.inc.php";
include_once "inc/prepareTitle.func.php";

//используем загруженный файл
$content = file_get_contents('feeds/'.$file_name); 
$xml = new SimpleXMLElement($content);

$timeStart = (float) microtime();

//считаем кол-во офферов
$prodTotal = $xml->shop->offers->offer->count();
echo "<h3>Всего товаров загружено: $prodTotal</h3>";
xmlLog($file_name, "Всего товаров загружено: $prodTotal.");

//считаем кол-во категорий
$catTotal = $xml->shop->categories->category->count();
echo "<h3>Всего категорий загружено: $catTotal</h3>";
xmlLog($file_name, "Всего категорий загружено: $catTotal.");

echo "</br></br>";

// логируем сообщения 
function xmlLog($file_name, $message)
{
    $logFile = fopen('logs/log_'.$file_name.'.txt', 'a') or die("Не удалось создать файл");
    fwrite($logFile, date('d.m.Y H:i:s').' — '."$message".PHP_EOL);
    fclose($logFile);
}


// условия доставки глобальные 
$deliveryOptions = "delivery-options";

if (!empty($xml->shop->$deliveryOptions))
{
    $deliveryCostGlobal = $xml->shop->$deliveryOptions->option['cost'];
    settype($deliveryCostGlobal, "float");
}
else
{
    xmlLog($file_name, "Global delivery options isn't set.");
}



// подготовка категорий

foreach ($xml->shop->categories->category as $category)
{
    $catsID[(int) $category['id']] = (string) $category;
    $catsParent[(int) $category['parentId']][(int) $category['id']] = (string) $category;
}

//доделать!
/*
function buildCategoryPath(array $categories, $productCategoryId) {
    if(is_array($categories)) {
        $path = '';
        if(isset($categories[$productCategoryId])) {
            $path .= $categories[$productCategoryId];
            $path .= ' > ';
        }
        foreach ($categories as $key => $value) {
            if (is_array($value)) {
                buildCategoryPath($value, $productCategoryId);
            }
        }
    }
    else return null;
    return $path;
}

echo "<br>";
print_r($catsID);
echo "<br>";
print_r($catsParent);
echo "<br>";
var_dump(buildCategoryPath($catsParent, 1));
*/

// создаем новый файл фида в формате Google
$newFeed = fopen('feeds/google/gf_'.$file_name, 'w') or die("Не удалось создать файл");
chmod('feeds/google/gf_'.$file_name, 0644);

// Основные данные
fwrite($newFeed, '<?xml version="1.0"?>'.PHP_EOL);
fwrite($newFeed, '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">'.PHP_EOL);
fwrite($newFeed, '<channel>'.PHP_EOL);
fwrite($newFeed, "<title>{$xml->shop->name}</title>".PHP_EOL);
fwrite($newFeed, "<link>{$xml->shop->url}</link>".PHP_EOL);
fwrite($newFeed, "<description>{$xml->shop->company}</description>".PHP_EOL);


// прорабатываем каждый товар
foreach ($xml->shop->offers->offer as $offer)
{

    // Объявляем переменные:

    // Если упрощенная модель, используем name
    if (!empty($offer->name))
    {
        $productTitle = $offer->name;
    }
    else
    {
        $productTitle = $offer->model;
    }

    if (!empty($offer->typePrefix))
    {
        $typePrefix = $offer->typePrefix;
    }


    $id = $offer['id'];
    $groupId = $offer['group_id'];
    
    $condition = $offer->condition;

    // Ц Е Н Ы
    $oldPrice = $offer->oldprice;
    settype($oldPrice, "float");

    $price = $offer->price;
    settype($price, "float");
    
    // Себестоимость
    if (!empty($offer->purchase_price))
    {
        $purchasePrice = $offer->purchase_price;
        settype($purchasePrice, "float");
    }

    // добавить проверку наличия секции и ошибку, если нет бренда
    $brand = $offer->vendor;
    $vendorCode = $offer->vendorCode;
    settype($vendorCode, "string");

    // В А Л Ю Т Ы *добавить проверку других валют
    if ($offer->currencyId == "RUR")
    {
        $currency = "RUB";
    }
    else
    {
        $currency = "RUB";
    }

    // доступность оффера
    if ($offer['available'] == 'false')
    {
        $available = false;
    }
    else
    {
        $available = true;
    }

    $weight = $offer->weight;
    settype($weight, "float");

    if (!empty($offer->$deliveryOptions))
    {
        $deliveryCostLocal = $offer->$deliveryOptions->option['cost'];
        settype($deliveryCostLocal, "float");
    }
    else
    {
        xmlLog($file_name, "Local delivery options isn't set for offer $id.");
    }
    
    if (!empty($offer->sales_notes))
    {
        $salesNotes = $offer->sales_notes;
        settype($salesNotes, "string");
    }
    else
    {
        xmlLog($file_name, "Sales notes isn't set for offer $id.");
    }



    // Записываем данные по каждому item

    fwrite($newFeed, '<item>'.PHP_EOL);

    fwrite($newFeed, "<link>{$offer->url}</link>".PHP_EOL);
    fwrite($newFeed, "<description><![CDATA[$offer->description]]></description>".PHP_EOL);
        
    foreach ($offer->picture as $picture)
    {
        fwrite($newFeed, "<g:image_link>{$picture}</g:image_link>".PHP_EOL);
    }

    // ЦЕНЫ Если есть oldprice, выводим обе цены и дату распродажи "вчера + неделя"
    if (! empty($oldPrice) && $oldPrice != $price)
    {
        fwrite($newFeed, "<g:price>$oldPrice $currency</g:price>".PHP_EOL);
        fwrite($newFeed, "<g:sale_price>$price $currency</g:sale_price>".PHP_EOL);
        
        $saleStart = date('Y-m-d', strtotime("-1 day"));
        $saleEnd = date('Y-m-d', strtotime("+1 week"));
        $saleDate = $saleStart . "T13:00+0300/" . $saleEnd . "T13:00+0300";
        fwrite($newFeed, "<g:sale_price_effective_date>$saleDate</g:sale_price_effective_date>".PHP_EOL);
    }
    else
    {
        fwrite($newFeed, "<g:price>$price $currency</g:price>".PHP_EOL);
    }
    
    if (isset($purchasePrice))
    {
        fwrite($newFeed, "<g:cost_of_goods_sold>$purchasePrice $currency</g:cost_of_goods_sold>".PHP_EOL);
    }

    
    // состояние товара: новый/БУ

    if ($condition)
    {
        if ($condition[0]['type'] == 'likenew' || $condition[0]['type'] == 'used')
        {
            fwrite($newFeed, "<g:condition>used [б/у]</g:condition>".PHP_EOL);
        }
    }
    else
    {
        fwrite($newFeed, "<g:condition>new</g:condition>".PHP_EOL);
    }
    

    fwrite($newFeed, "<g:id>$id</g:id>".PHP_EOL);
    
    if (!empty($groupId))
    {
        fwrite($newFeed, "<g:item_group_id>$groupId</g:item_group_id>".PHP_EOL);
    }
    
    fwrite($newFeed, "<g:brand>$brand</g:brand>".PHP_EOL);
    
    if (!empty($vendorCode))
    {
        fwrite($newFeed, "<g:mpn>$vendorCode</g:mpn>".PHP_EOL);
    }
    
    // доступность товара
    if ($available == true)
    {
        fwrite($newFeed, "<g:availability>in stock</g:availability>".PHP_EOL);
    }
    elseif ($available == false)
    {
        fwrite($newFeed, "<g:availability>out of stock</g:availability>".PHP_EOL);
    }
    
    //разбор фишек товара, которые обычно в sales_notes
    if (isset($salesNotes))
    {
        fwrite($newFeed, "<g:product_highlight>$salesNotes</g:product_highlight>".PHP_EOL); 
    }

    

    // путь категорий в типе товара * доделать.
    // Внутренняя категория товара. Формат: Главная > Женская одежда > Платья > Длинные платья
    $productCategoryId = $offer->categoryId;
    settype($productCategoryId, "string");
      
    foreach ($xml->shop->categories->category as $category)
    {
        if ($productCategoryId == $category['id'])
        {
            fwrite($newFeed, "<g:product_type>$category</g:product_type>".PHP_EOL);
        }
    }
            
    // проверка параметров товара 
    // добавить установку <g:size_system>US</g:size_system> для размера
    
    foreach ($offer->param as $param)
    {
        $paramName = $param['name'];
        $paramUnit = $param['unit'];
        $paramValue = $param;
            
        if (isset($paramUnit))
        {
            $attribute_value = $paramValue . ' ' . $paramUnit;
        }
        else
        {
            $attribute_value = $paramValue;
        }


        if ($paramName == 'Цвет' or $paramName == 'цвет')
        {
            $productColor = $param;
            settype($productColor, "string");
            fwrite($newFeed, "<g:color>$productColor</g:color>".PHP_EOL);
        }
        elseif ($paramName == 'Размер' or $paramName == 'размер')
        {
            $productSize = $param;
            settype($productSize, "string");
            fwrite($newFeed, "<g:size>$productSize</g:size>".PHP_EOL);
        }
        elseif ($paramName == 'Материал' or $paramName == 'материал')
        {
            $productMaterial = $param;
            settype($productMaterial, "string");
            fwrite($newFeed, "<g:material>$productMaterial</g:material>".PHP_EOL);
        }
        elseif ($paramName == 'Пол' or $paramName == 'пол')
        {

            if ($param == 'мужской' or $param == 'Мужской' or $param == 'муж' or $param == 'м')
            {
                $productGender = 'male [мужской]';
            }
            elseif ($param == 'женский' or $param == 'Женский' or $param == 'жен' or $param == 'ж')
            {
                $productGender = 'female [женский]';
            }
            elseif ($param == 'унисекс' or $param == 'Унисекс')
            {
                $productGender = 'unisex [унисекс]';
            }

            fwrite($newFeed, "<g:gender>$productGender</g:gender>".PHP_EOL);
        }
        else
        {
            fwrite($newFeed, "<g:product_detail>".PHP_EOL);
            fwrite($newFeed, "  <g:section_name>Характеристики</g:section_name>".PHP_EOL);
            fwrite($newFeed, "  <g:attribute_name>$paramName</g:attribute_name>".PHP_EOL);
            fwrite($newFeed, "  <g:attribute_value>$attribute_value</g:attribute_value>".PHP_EOL);
            fwrite($newFeed, "</g:product_detail>".PHP_EOL);
        }

    }

    
    // Формируем заголовок **TODO: вставляет цвет к последнему офферу, хотя его там нет.
    $newTitle = prepareTitle($typePrefix, $brand, $productTitle, $productColor);
    fwrite($newFeed, "<title>$newTitle</title>".PHP_EOL);

    // товары для взрослых
    if (!empty($xml->adult) and $xml->adult == 'true')
    {
        fwrite($newFeed, "<g:adult>yes [да]</g:adult>".PHP_EOL);
    }
    else
    {
        fwrite($newFeed, "<g:adult>no [нет]</g:adult>".PHP_EOL);
    }

    // записываем все штрихкоды
    $barcode = $offer->barcode;
    
    foreach ($barcode as $barcode)
    {
        settype($barcode, "int");
        fwrite($newFeed, "<g:gtin>$barcode</g:gtin>".PHP_EOL);
    }   


    // добавить свойство <g:unit_pricing_measure>750 ml</g:unit_pricing_measure>
    // добавить свойство <g:unit_pricing_base_measure>100oz</g:unit_pricing_base_measure> - указана базовая единица, цена которой отображается в объявлении.
    // добавить проверку по типу товара <typePrefix>
    // добавить проверку <g:google_product_category>2271</g:google_product_category>. Мануал: https://support.google.com/merchants/answer/6324436?hl=ru&ref_topic=6324338
    // добавить проверку <g:is_bundle>yes [да]</g:is_bundle> -- набор товаров
    // добавить проверку <g:age_group>adult [взрослые]</g:age_group>. Значения: newborn [новорожденные], infant [младенцы], toddler [маленькие_дети], kids [дети], adult [взрослые]
    /* добавить разбор параметров. Пример:
        <g:product_detail>
            <g:section_name>Общие сведения</g:section_name> -- заголовок
            <g:attribute_name>Тип товара</g:attribute_name> -- название атрибута
            <g:attribute_value>Цифровой проигрыватель</g:attribute_value> -- значение
        </g:product_detail>
    */

    if (!empty($offer->dimensions))
    {
        $data = $offer->dimensions;
        list($length, $width, $height) = explode("/", $data);

        fwrite($newFeed, "<g:shipping_length>$length cm</g:shipping_length>".PHP_EOL);
        fwrite($newFeed, "<g:shipping_width>$width cm</g:shipping_width>".PHP_EOL);
        fwrite($newFeed, "<g:shipping_height>$height cm</g:shipping_height>".PHP_EOL);
    }

    // условия доставки

    if ($offer->delivery == 'true')
    {
        $deliveryOffer = true;
    
        fwrite($newFeed, '<g:shipping>'.PHP_EOL);
        fwrite($newFeed, "<g:country>RU</g:country>".PHP_EOL);
        fwrite($newFeed, "<g:service>Курьерская доставка</g:service>".PHP_EOL);
    
        if (isset($deliveryCostLocal))
        {
            fwrite($newFeed, "<g:price>$deliveryCostLocal $currency</g:price>".PHP_EOL);
        }
        elseif (isset($deliveryCostGlobal))
        {
            fwrite($newFeed, "<g:price>$deliveryCostGlobal $currency</g:price>".PHP_EOL);
        }
    
        fwrite($newFeed, '</g:shipping>'.PHP_EOL);
    }
    elseif ($offer->delivery == 'false')
    {
        $deliveryOffer = false;
    }

    if (!empty($weight))
    {
        fwrite($newFeed, "<g:shipping_weight>$weight кг</g:shipping_weight>".PHP_EOL);
    }
    

    fwrite($newFeed, '</item>'.PHP_EOL);
}
fwrite($newFeed, '</channel>'.PHP_EOL);
fwrite($newFeed, '</rss>'.PHP_EOL);

fclose($newFeed);

$timeEnd = (float) microtime();

$timeElapsed = $timeEnd - $timeStart;

echo "Time elapsed: $timeElapsed sec.<br><br>";
xmlLog($file_name, "Time elapsed: $timeElapsed sec.");
echo "<a href='feeds/google/gf_$file_name'>Ссылка на скачивание нового фида</a>";

?>

</body>
</html>