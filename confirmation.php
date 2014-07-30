<?php
require_once "includes/init.inc.php";


$response = isset($_SESSION["checkout_response"]) ? json_decode($_SESSION["checkout_response"]) : null;

if(!$response){
	header("location: ./");
	exit;
}

if($response->status==2){
	Cart::setEmpty();
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<link rel="stylesheet" href="style.css" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<title>Lojinha Gerencianet</title>
	</head>
	<body>
		<?php include "includes/header.inc.php"; ?>
		<div class="confirmation text-bold">
			<?php
				if($response->status==2) {
					echo "<img src='images/icon-success.png' class='success' />
						  <div class='color-green'>Transação realizada com sucesso</div>";
				} else {
					echo "<img src='images/icon-error.png' class='error' />
					      <div class='color-orange'>Ocorreu algum problema e a transação não pode ser efetuada</div>";
				}

				if($response!=null) {
					echo "<div class='details'>";
					if($response->status==2) {
						if($response->resposta->tipo=="cartao-credito") {
							echo "N° de parcelas: " . $response->resposta->quantidadeParcelas . "<br>";
							echo "Valor da parcela: " . formatMoney($response->resposta->valorDaParcela / 100);
						} elseif($response->resposta->tipo=="boleto") {
							echo "<p>Código do boleto: <b>" . $response->resposta->codigoBarra . "</b></p>";
							echo "<p>Você tem até <b>". date('d/m/Y', strtotime($response->resposta->vencimentoBoleto)) . "</b> para efetuar o pagamento de seu boleto.</p>";
							echo "<p><a target='_blank' href='" . $response->resposta->linkBoleto . "' class='color-green link'>Exibir Boleto</a></p>";
						}
					} elseif($response->status==1) {
						echo "
								Problema(s) apresentado(s):
								<ul>";
						if(is_array($response->erros->erro)) {
							foreach($response->erros->erro as $e) {
								echo "<li>" . $e . "</li>";
							}
						} else {
							echo "<li>" . $response->erros->erro . "</li>";
						}
						echo "</ul>";
					}
					echo "</div>";
				}
			?>
			</div>
		<?php include "includes/footer.inc.php"; ?>
	</body>
</html>