<?php

class Product {

	private $id;
	private $description;
	private $price;
	private $img;
	private $color;
	private $additional_info;

	public function __construct($id, $description, $price, $img, $color, $additional_info) {
		$this->id = $id;
		$this->description = $description;
		$this->price = $price;
		$this->img = "images/products/" . $img;
		$this->color = explode(";", $color);
		$this->additional_info = explode(";", $additional_info);
	}

	public function __get($attr){
		return $this->$attr;
	}
	
	public static function getProductById($id){
		$db = new DB();
		if(is_numeric($id)){
			$res = $db->query("SELECT id, description, price, image, color, additional_info FROM products WHERE id=" . $id . ";");
			if($res instanceof SQLite3Result){
				if($r = $res->fetchArray(SQLITE3_ASSOC)){
					return new Product($r["id"], $r["description"], $r["price"], $r["image"], $r["color"], $r["additional_info"]);
				}
			}
		}
		return null;
	}

	public static function getProductsList(){
		$db = new DB();
		$res = $db->query("SELECT id, description, price, image, color, additional_info FROM products;");
		if($res instanceof SQLite3Result){
			$list = array();
			while($r = $res->fetchArray(SQLITE3_ASSOC)){
				$prd = new Product($r["id"], $r["description"], $r["price"], $r["image"], $r["color"], $r["additional_info"]);
				$list[] = $prd;
			}
			return $list;
		}
		return null;
	}

}
