<?php

interface dbWorker {
  
  // ищем продукт в БД
  public function searchProd($barcode);

  // добавляем товар в базу данных
  public function addProductToDB($id);

  // добавляем отсутствующие свойства в товар в БД
  public function addPropToDB($id);


}

interface other {

 // ищем свойства у конкретного товара
 public function searchProp($id, $property);

 // записываем в файл
 public function writeToFile ($id);

}

class product {

  //свойства, характеристики
	private $id;
  private $barcode;
  private $available;
  private $groupId;

  private $typePrefix;
  private $model;
  private $name;
  private $url;
  private float $price;
  private float $oldPrice;
  private float $purchasePrice; 
  private $currencyId;
  private $categoryId;
  private $picture;

  private $store;
  private $pickup;
	private $delivery;
  private $localDeliveryCost;

  private $vendor;
  private $vendorCode;
  private $ogrn;

  private $description;
  private $salesNotes;
  private $countryOfOrigin;
  private float $weight;
  private $dimensions;
  private $manufacturerWarranty;

  private $color;
  private $material;
  private $size;
  private $minQantity;
  private $conditionType;
  private $ageGroup;
  private $gender;

  private array $params;
  private int $barcodes;
  private $categories;
  private array $properties;
  
    
  // setters
  public function setId($id)
  {
    $this->id = $id;
  }
  public function setBarcode($barcode)
  {
    $this->barcode = $barcode;
  }
  public function setAvailable($available)
  {
    $this->available = $available;
  }
  public function setGroupId($groupId)
  {
    $this->groupId = $groupId;
  }
  public function setTypePrefix($typePrefix)
  {
    $this->typePrefix = $typePrefix;
  }
  public function setModel($model)
  {
    $this->model = $model;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function setUrl($url)
  {
    $this->url = $url;
  }
  public function setPrice($price)
  {
    $this->price = $price;
  }
  public function setOldPrice($oldPrice)
  {
    $this->oldPrice = $oldPrice;
  }
  public function setPurchasePrice($purchasePrice)
  {
    $this->purchasePrice = $purchasePrice;
  }
  public function setCurrencyId($currencyId)
  {
    $this->currencyId = $currencyId;
  }
  public function setCategoryId($categoryId)
  {
    $this->categoryId = $categoryId;
  }
  public function setPicture($picture)
  {
    $this->picture = $picture;
  }
  public function setStore($store)
  {
    $this->store = $store;
  }
  public function setPickup($pickup)
  {
    $this->pickup = $pickup;
  }
  public function setDelivery($delivery)
  {
    $this->delivery = $delivery;
  }
  public function setLocalDeliveryCost($localDeliveryCost)
  {
    $this->localDeliveryCost = $localDeliveryCost;
  }
  public function setVendor($vendor)
  {
    $this->vendor = $vendor;
  }
  public function setVendorCode($vendorCode)
  {
    $this->vendor = $vendorCode;
  }
  public function setOgrn($ogrn)
  {
    $this->ogrn = $ogrn;
  }

  // getters

  public function getId()
  {
  return $this->id;
  }
  public function getBarcode()
  {
  return $this->barcode;
  }
  public function getAvailable()
  {
  return $this->available;
  }
  public function getGroupId()
  {
  return $this->groupId;
  }
  public function getTypePrefix()
  {
  return $this->typePrefix;
  }
  public function getModel()
  {
  return $this->model;
  }
  public function getName()
  {
  return $this->name;
  }
  public function getUrl()
  {
  return $this->url;
  }
  public function getPrice()
  {
  return $this->price;
  }
  public function getOldPrice()
  {
  return $this->oldPrice;
  }
  public function getPurchasePrice()
  {
  return $this->purchasePrice;
  }
  public function getCurrencyId()
  {
  return $this->currencyId;
  }
  public function getCategoryId()
  {
  return $this->categoryId;
  }
  public function getPicture()
  {
  return $this->picture;
  }
  public function getStore()
  {
  return $this->store;
  }
  public function getPickup()
  {
  return $this->pickup;
  }
  public function getDelivery()
  {
  return $this->delivery;
  }
  public function getLocalDeliveryCost()
  {
  return $this->localDeliveryCost;
  }



}


?>