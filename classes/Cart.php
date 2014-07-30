<?php

class Cart {

	private static function getSessionCart(){
		return isset($_SESSION["cart"]) && is_array($_SESSION["cart"]) ? $_SESSION["cart"] : array();
	}

	public static function getItensCount(){
		$cart = self::getSessionCart();
		$count = 0;
		foreach($cart as $qty){
			$count += $qty;
		}
		return $count;
	}

	public static function getTotalWeight(){
		$itens = self::getItens();
		$weight = 0;
		foreach($itens as $i){
			$info = explode(" ", $i["prod"]->additional_info[2]);
			$weight += ($info[0] * $i["qty"]) / 1000;
		}
		return $weight;
	}

	public static function getItens(){
		$cart = self::getSessionCart();
		$itens = array();
		foreach($cart as $id=>$qty){
			$prod = Product::getProductById($id);
			if($prod){
				$itens[$id] = array("prod"=>$prod, "qty"=>$qty, "total"=>$prod->price*$qty);
			}
		}
		return $itens;
	}

	public static function getTotalPrice(){
		$cart = self::getSessionCart();
		$total = 0;
		foreach($cart as $id=>$qty){
			$prod = Product::getProductById($id);
			if($prod){
				$total += $prod->price * $qty;
			}
		}
		return $total;
	}

	public static function getTotalPriceWithTaxes(){
		$total = self::getTotalPrice();
		if($total>0){
			$freight = isset($_SESSION['freight']) && is_numeric($_SESSION['freight'][0]) ? $_SESSION['freight'][0] : 0;
			$total += $freight + 1.5;
		}
		return $total;
	}

	public static function getTaxes(){
		if(self::getTotalPrice()>0){
			$freight = isset($_SESSION['freight'][0]) && is_numeric($_SESSION['freight'][0]) ? $_SESSION['freight'][0] : 0;
			$freight += 1.5;
			return $freight;
		}
		return 0;
	}

	public static function setItem($id, $qty){
		$cart = self::getSessionCart();
		foreach($cart as $itemId=>$itemQty){
			if(Product::getProductById($itemId)==null || ($id==$itemId && $qty<=0)){
				unset($cart[$itemId]);
			}
		}

		if($qty>0 && Product::getProductById($id)!=null){
			$cart[$id] = $qty;
		}

		$_SESSION["cart"] = $cart;
	}

	public static function setEmpty(){
		$_SESSION["cart"] = array();
		unset($_SESSION['checkout_response']);
		unset($_SESSION['freight']);
		unset($_SESSION['cep_destination']);
	}

	public static function getWarnings(){
		$warnings = array();
		if((self::getTotalPriceWithTaxes() - 1.5) < 5){
			$warnings[] = "Valor mínimo de R$5 por compra (exceto taxa de administração de risco)";
		}
		if(!isset($_SESSION["cep_destination"]) || !(isset($_SESSION["freight"]) && $_SESSION["freight"][0]<>0)){
			$warnings[] = "Calcule o frete para prosseguir com a compra";
		}
		return $warnings;
	}

}