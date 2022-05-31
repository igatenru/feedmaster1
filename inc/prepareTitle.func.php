<?php

/*
$typePrefix = 'Сендвичница';
$brand = 'Redmond';
$productTitle = ' VFX80 AF';
$productColor = 'белый';
*/

// levenshtein() -- использовать для сравнения слов.

function prepareTitle($typePrefix, $brand, $productTitle, $productColor): string
{
    $readyTitle = "";

    if (! empty($typePrefix) && mb_stripos($productTitle, $typePrefix) === false)
    {
        $readyTitle .= $typePrefix;
    }

    if (mb_stripos($productTitle, $brand) === false)
    {
        $readyTitle .= " $brand" . " $productTitle";
    }
    else
    {
        $readyTitle .= " $productTitle";
    }

    if (! empty($productColor))
    {
        $readyTitle .= ", $productColor";
    }

    return trim($readyTitle);
}
?>