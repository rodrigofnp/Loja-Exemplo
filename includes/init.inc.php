<?php
session_start();

function __autoload($className){
	require_once __DIR__ . "/../classes/" . $className . ".php";
}

function formatMoney($value){
	return "R$ " . number_format($value, 2, ",", ".");
}

header("Content-type: text/html; charset=UTF-8");