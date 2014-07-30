<?php
	require_once "includes/init.inc.php";

	$id = $_GET['id'];

	$product = Product::getProductById($id);
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

		<div class="product-selected">
			<div class="path color-gray"><a href="./" class="color-gray">INÍCIO</a> >> <?php echo $product->description; ?></div>
			<div class='divider'></div>

			<div class="clear">
				<div class="pull-left image">
					<img src="<?php echo $product->img; ?>" />
				</div>
				<div class="pull-left information">
					<p class='text-bold'><?php echo $product->description; ?></p>
					<p class='text-bold color-orange'><?php echo formatMoney($product->price); ?></p>
					<div class="button text-bold">
						<?php
						$cart = Cart::getItens();
						$cartIds = array_keys($cart);
						$qty = in_array($product->id, $cartIds) ? $cart[$product->id]["qty"]+1 : 1;
						?>
						<a href="<?php echo "actions/add-to-cart.php?product=".$product->id."&qty=".$qty; ?>">EU QUERO!</a>
					</div>
					<div class="favorite">
						<img src="images/icons-favorite.png">
					</div>
				</div>
			</div>
			<div class="additional-information">
				<div class="title">INFORMAÇÕES ADICIONAIS</div>
				<table>
					<tr>
						<td class="column1">CÓDIGO DO PRODUTO</td>
						<td class="text-bold"><?php echo $product->id; ?></td>
					</tr>
					<tr>
						<td class="column1">MATERIAL</td>
						<td class="text-bold"><?php echo $product->additional_info[0]; ?></td>
					</tr>
					<tr>
						<td class="column1">COR</td>
						<td class="text-bold"><?php echo $product->additional_info[1]; ?></td>
					</tr>
					<tr>
						<td class="column1">MARCA</td>
						<td class="text-bold">Gerencianet</td>
					</tr>
					<tr>
						<td class="column1">PESO</td>
						<td class="text-bold"><?php echo $product->additional_info[2]; ?></td>
					</tr>
					<tr>
						<td class="column1">CATEGORIA</td>
						<td class="text-bold"><?php echo $product->additional_info[3]; ?></td>
					</tr>
				</table>
			</div>
		</div>
		
		<div class="messages clear text-italic">
			<div class="content">
				<div class="pull-left list">
					<p class="text-bold title">VENDA MAIS E RECEBA COM QUALIDADE</p>
					<p>Com a Gerencianet, seus clientes podem pagar com cartão de crédito ou boleto de qualquer lugar, e você recebe mais rápido.</p>
				</div>
				<div class="pull-left list">
					<p class="text-bold title">DEIXE SEU SITE TRABALHAR POR VOCÊ</p>
					<p>Automatize as etapas de pagamento, integrando seu site ao nosso sistema, e receba de seus clientes de forma rápida e segura.</p>
				</div>
				<div class="pull-left list">
					<p class="text-bold title">MELHOR JEITO DE COMPRAR</p>
					<p>Utilize a Gerencianet para fazer pagamentos.</p>
					<p>Seus dados são protegidos e você recebe seu dinheiro de volta caso tenha problemas com a entrega do produto ou serviço.</p>
				</div>
			</div>
		</div>

		<?php include "includes/footer.inc.php"; ?>
	</body>
</html>