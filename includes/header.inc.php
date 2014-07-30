<?php

$qtdeProducts = count(Cart::getItens());
$page = isset($_GET["pagina"]) ? $_GET["pagina"] : '';

?>

<div class="header">
	<div class="header-content">
		<div class="header-logo">
			<a href="./"><img src="images/marca-gerencianet.png" /></a>
		</div>
		<div class="header-menu">
			<div class="menu">
				<ul>
					<li <?php if($page=="home") echo 'class="menu-active"'; ?>><a href="./">HOME</a></li>
					<li><a href="#">DESTAQUES</a></li>
					<li <?php if($page=="produto") echo 'class="menu-active"'; ?>><a href="#">VITRINE</a></li>
					<li><a href="#">BLOG</a></li>
					<li><a href="https://github.com/gerencianet/Loja-Exemplo" target="_blank"><i class="fa fa-github"></i> GITHUB</a></li>
					<li class="menu-cart <?php if($page=='carrinho' || $page=='pagamento') echo 'menu-active'; ?>"><a href="./carrinho">CARRINHO <?php echo $qtdeProducts<>0 ? "<div class='qtdeProducts text-bold'>" . $qtdeProducts . "</div>" : ''; ?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>