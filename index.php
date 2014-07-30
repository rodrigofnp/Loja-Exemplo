<?php
	require_once "includes/init.inc.php";

	$products = Product::getProductsList();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<link rel="stylesheet" href="style.css" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<title>Lojinha Gerencianet</title>
		<?php
		echo "<style>";
		if($products != null){
			foreach($products as $p){
				echo ".prod-".$p->id."{";
				$tam = count($p->color);
				echo "background-color: " . $p->color[0] . ";";
				if($tam > 1){
					$gradient = 'background: linear-gradient(315deg';
					$space = 0;
					echo "background: -webkit-linear-gradient(315deg";
					for($i = 0; $i < $tam; $i++){
						echo ", " . $p->color[$i];
						$gradient .= ", " . $p->color[$i];
						if($i < $tam) {
							if($tam == 3 && $i < ($tam - 1)) {
								$space += 33;
							} else if($tam == 3 && $i == ($tam - 1)) {
								$space += 34;
							} else {
								$space += 50;
							}
							echo " " . $space . "%, transparent " . $space . "%";
							$gradient .=  " " . $space . "%, transparent " . $space . "%";
						}
						if($i < ($tam - 1)) {
							echo "), -webkit-linear-gradient(315deg";
							$gradient .= "), linear-gradient(315deg";
						}
					}
					echo "); \n";
					echo $gradient . ");";
					
				}
				echo "}\n";
			}
		}
		echo "</style>";
		?>
	</head>
	<body>
		<?php include "includes/header.inc.php"; ?>
		<div class="header-banner"></div>
		<div class="showcase">
			<h1 class="color-green">VITRINE</h1>
			<?php
			if($products!=null){
				$breakAfter = 4;
				$i = 0;
				foreach($products as $p){
					$i++;
					if($i>$breakAfter){
						$i = 1;
						echo "<div class='divider'></div>";
					}
					?>
					<div class="product-box">
						<a href="produto-<?php echo $p->id; ?>">
							<img class="product-img" src="<?php echo $p->img; ?>">
						</a>
						<div class="clear">
							<div class="pull-left product-info">
								<div class="product-description"><?php echo $p->description; ?></div>
								<div class="product-price"><?php echo formatMoney($p->price); ?></div>
							</div>
							<div class="pull-right">
								<div class="product-color prod-<?php echo $p->id; ?>"></div>
							</div>
						</div>
						<div class="product-buy-btn">
							<?php
							$cart = Cart::getItens();
							$cartIds = array_keys($cart);
							$qty = in_array($p->id, $cartIds) ? $cart[$p->id]["qty"]+1 : 1;
							?>
							<a href="<?php echo "actions/add-to-cart.php?product=".$p->id."&qty=".$qty; ?>">COMPRAR</a>
						</div>
					</div>
					<?php
				}
				echo "<div class='divider'></div>";
			}
			?>
		</div>

		<div class="informations">
			<a href="" class="link color-green">PREÇO</a>
			<a href="" class="link color-green text-bold">NOVIDADES</a>
			<a href="" class="link color-green">MAIS VENDIDOS</a>
			<a href="" class="link color-green">MAIS VISTOS</a>
			<label class="results-per-page">
				Exibir 
					<select disabled>
						<option value="20">20</option>
					</select>
					registros por página	
			</label> 
			<label class="change-pages">
				<input type="text" value="<< Primeiro" class="large-button disabled color-gray" disabled />
				<input type="text" value="<" class="small-button disabled color-gray" disabled />
				<input type="text" value="1" class="small-button selected color-green" disabled />
				<input type="text" value="2" class="small-button enabled color-green" disabled />
				<input type="text" value="3" class="small-button enabled color-green" disabled />
				<input type="text" value=">" class="small-button enabled color-green" disabled />
				<input type="text" value="Último >>" class="large-button enabled color-green" disabled />
			</label>
		</div>

		<?php include "includes/footer.inc.php"; ?>
	</body>
</html>