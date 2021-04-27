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
		public $id;
    public $barcode;
    public $available;
    public $group_id;

    public $typePrefix;
    public $model;
    public $name;
    public $url;
    public float $price;
    public float $oldprice;
    public float $purchase_rice; 
    public $currencyId;
    public $categoryId;
    public $picture;

    public $store;
    public $pickup;
		public $delivery;
    public $local_delivery_cost;

    public $vendor;
    public $vendorCode;
    public $ogrn;

    public $description;
    public $sales_notes;
    public $country_of_origin;
    public float $weight;
    public $dimensions;
    public $manufacturer_warranty;

    public $color;
    public $material;
    public $size;
    public $min_qantity;
    public $condition_type;
    public $age_group;
    public $gender;


    public array $params;
    public int $barcodes;
    public $categories;
    public array $properties;
  
  
      public function searchProd($barcode) {
          ## ищем похожий товар в БД
      }
  
      public function addToDB($id) {
          ## добавляем товар в базу данных
      }
      
      public function searchProp($id, $property) {
          ## ищем свойства у конкретного товара
      }
  
      public function addProp($id) {
          ## добавляем отсутствующие свойства в товар в БД
      }
      
      public function writeToFile ($id) {
          ## записываем в файл
      }
  
  }








?>