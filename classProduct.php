<?php

interface iProduct {
  
  // ищем продукт в БД
  public function searchProd($barcode);

  // добавляем товар в базу данных
  public function addToDB($id);

  // ищем свойства у конкретного товара
  public function searchProp($id, $property);

  // добавляем отсутствующие свойства в товар в БД
  public function addProp($id);

  // записываем в файл
  public function writeToFile ($id);

}



class product implements iProduct {

  //свойства
	private $id;
  private $barcode;
  private $available;
  private $groupId;

  private $typePrefix;
  private $model;
  private $name;
  private $url;
  private float $price;
  private float $oldprice;
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
  
  
  public function searchProd($barcode)
  {
    ## ищем похожий товар в БД
  }
  
  public function addToDB($id)
  {
    ## добавляем товар в базу данных
  }
      
  public function searchProp($id, $property)
  {
    ## ищем свойства у конкретного товара
  }
  
  public function addProp($id)
  {
    ## добавляем отсутствующие свойства в товар в БД
  }
      
  public function writeToFile ($id)
  {
    ## записываем в файл
  }
  
  
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

  public function setOldprice($oldprice)
  {
    $this->oldprice = $oldprice;
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







}








?>