<?php
require_once "../includes/init.inc.php";

$prdId = isset($_GET["product"]) && is_numeric($_GET["product"]) ? $_GET["product"] : 0;
$qty = isset($_GET["qty"]) && is_numeric($_GET["qty"]) ? $_GET["qty"] : 1;

Cart::setItem($prdId, $qty);


 header("location: ./calculate-freight.php?cep_destination=".$_SESSION['cep_destination']);