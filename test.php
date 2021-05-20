<?php

$typePrefix = 'Сэндвичница';
$brand = 'Redmond';
$productTitle = ' VFX80 AF redmond';
$productColor = 'белый';

// levenshtein() -- использовать для сравнения слов.
function prepareTitle($typePrefix, $brand, $productTitle, $productColor) {
    if (mb_stripos($productTitle, $brand) === false) {
        $result = $typePrefix . ' ' . $brand . ' ' . $productTitle . ', ' . $productColor;
    }
    else {
        $result = $typePrefix . ' ' . $productTitle . ', ' . $productColor;
    }
    return $result;
}

echo prepareTitle($typePrefix, $brand, $productTitle, $productColor);




?>