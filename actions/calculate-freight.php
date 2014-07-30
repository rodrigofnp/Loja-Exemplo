<?php
require_once "../includes/init.inc.php";

function calculate_freight($service, $cep_origin, $cep_destination, $weight, $own_hand, $declared_value, $notice_receipt){
	$own_hand = (strtolower($own_hand) == 's') ? 's' : 'n';
	$notice_receipt = (strtolower($notice_receipt) == 's') ? 's' : 'n';
	$url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem='. $cep_origin 
			.'&sCepDestino='. $cep_destination .'&nVlPeso='. $weight .'&nCdFormato=1&nVlComprimento=20&nVlAltura=5&nVlLargura=15&sCdMaoPropria='
			. $own_hand .'&nVlValorDeclarado='. $declared_value .'&sCdAvisoRecebimento='. $notice_receipt .'&nCdServico='. $service 
			.'&nVlDiametro=0&StrRetorno=xml';
	$freight_calculate = simplexml_load_string(file_get_contents($url));
	
	$freight = $freight_calculate->cServico;
	if($freight->Erro == '0'){
	    $response[0] = (double)str_replace(',', '.', $freight->Valor);
	    $response[1] = $freight->PrazoEntrega.' dia'.($freight->PrazoEntrega<>1 ? "s" : "");
	}elseif($freight->Erro == '7'){
		$response[0] = 0;
	    $response[1] = 'Serviço temporariamente indisponível, tente novamente mais tarde.';
	}else{
		$response[0] = 0;
	    $response[1] = 'Erro no cálculo do frete: '.$freight->MsgErro;

	}

	return $response;
}


if(isset($_GET['cep_destination'])) {
	$cep_destination = $_GET['cep_destination'];
	$_SESSION['cep_destination'] = $cep_destination;
	$cep_destination = str_replace('-', '', $cep_destination);
	$_SESSION['freight'] = calculate_freight('40010', '35400000', $cep_destination, Cart::getTotalWeight(), 'n', '0', 's');	
} else {
	unset($_SESSION['freight']);
	unset($_SESSION['cep_destination']);
}

header("location: ../carrinho");
