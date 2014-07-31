<?php
require_once "../includes/init.inc.php";

$cep = isset($_GET["cep"]) ? $_GET["cep"] : '';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://cep.correiocontrol.com.br/" . $cep . ".json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resp = curl_exec($ch);
curl_close($ch);

if(!preg_match("/^\d{8}$/", $cep) || preg_match("/^correiocontrolcep/", $resp)){
	echo "{erro : 'cep inválido'}";
} else {
	echo $resp;
}