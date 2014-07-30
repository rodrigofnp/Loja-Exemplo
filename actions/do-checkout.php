<?php
require_once "../includes/init.inc.php";

$metodo = $_POST['metodo'];
$cliente = $_POST['cliente'];
$enderecoEntrega = $_POST['enderecoEntrega'];
$tokenPagamento = $_POST['tokenPagamento'];

$xmlData = array(
	"itens"=>array(),
	"cliente"=>array(
		"nome" => $cliente['nome'],
		"cpf" => $cliente['cpf'],
		"email" => $cliente['email'],
		"nascimento" => $cliente['nascimento'],
		"celular" => $cliente['celular']
		),
	"enderecoEntrega" => array(
		"logradouro" => $enderecoEntrega['logradouro'],
		"numero" => $enderecoEntrega['numero'],
		"bairro" => $enderecoEntrega['bairro'],
		"cidade" => $enderecoEntrega['cidade'],
		"cep" => $enderecoEntrega['cep'],
		"estado" => $enderecoEntrega['estado']
		)
	);

if($metodo == 'cartao-credito') {
	$formaPagamento = $_POST['formaPagamento']['cartao'];
	$xmlData["formaPagamento"] = array(
		"cartao" => array(
				"parcelas" => $formaPagamento['parcelas'],
				"enderecoCobranca" => array(
					"logradouro" => $formaPagamento['enderecoCobranca']['logradouro'],
					"numero" =>$formaPagamento['enderecoCobranca']['numero'],
					"bairro" => $formaPagamento['enderecoCobranca']['bairro'],
					"cidade" => $formaPagamento['enderecoCobranca']['cidade'],
					"cep" => $formaPagamento['enderecoCobranca']['cep'],
					"estado" => $formaPagamento['enderecoCobranca']['estado']
					)
				)
		);
} else {
	$date = date('Y-m-d', strtotime("+3 days"));
	$xmlData["formaPagamento"] = array(
		"boleto" => array(
			'vencimento' => $date
			)
		);
}

if(isset($_POST['outros'])) {
	$outros = $_POST['outros'];
	$xmlData["frete"] = $outros['frete'];
}

foreach(Cart::getItens() as $item) {
	$xmlData['itens'][] = array('itemDescricao' => $item["prod"]->description,
		'itemValor' => ($item["prod"]->price * 100),
		'itemQuantidade' => $item["qty"]
		);
}

$integrationToken = "seu_token_aqui";
$paymentToken = $tokenPagamento;

$resp = ApiCheckoutGerencianet::pagar($xmlData, $integrationToken, $paymentToken);

$respXml = simplexml_load_string($resp);
$_SESSION["checkout_response"] = json_encode($respXml);

echo json_encode($respXml);
