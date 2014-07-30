<?php
require_once "includes/init.inc.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<link rel="stylesheet" href="style.css" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<title>Lojinha Gerencianet</title>
		<script language="JavaScript" type="text/javascript" src="./javascript/masks.js"></script>
		<script language="JavaScript" type="text/javascript" src="./javascript/validation-checkout.js"></script>
		<script language="JavaScript" type="text/javascript" src="./javascript/checkout-control.js"></script>
		<!-- Seu script aqui -->
	</head>
	<body>
		<?php include "includes/header.inc.php"; 
			if(Cart::getTotalPriceWithTaxes() >= 5) {
		?>
		<form action="./actions/do-checkout.php" data-gn-submit data-gn-callback-sucesso="confirm" data-gn-callback-erro="confirm" method="post" >
			<div class="checkout">
				<h1 class="color-green">EFETUAR PAGAMENTO</h1>
				<div class="checkout-user-form">
						<h2>Resumo da compra</h2>
						<table class="table ">
							<tr class="text-bold text-center">
								<td class="column">Quantidade de Itens</td>
								<td class="column">Valor dos Itens</td>
								<td class="column">Valores Adicionais</td>
								<td class="column">Valor Total</td>
							</tr>
							<tr class="text-center">
								<td class="column"><?php echo Cart::getItensCount(); ?></td>
								<td class="column"><?php echo formatMoney(Cart::getTotalPrice()); ?></td>
								<td class="column"><?php echo formatMoney(Cart::getTaxes()); ?></td>
								<td class="column"><?php echo formatMoney(Cart::getTotalPriceWithTaxes()); ?></td>
							</tr>
						</table>
						<input type="hidden" id='total' value="<?php echo ((Cart::getTotalPriceWithTaxes() - 1.5) * 100); ?>" data-gn-total />
						<input type="hidden" name="frete" value="<?php echo ((Cart::getTaxes() - 1.5) * 100); ?>" />
				</div>

				<div class="checkout-user-form">
					<div class="clear">
						<div class="checkout-pass pull-left">
							1
						</div>
						<div class="pull-left">
							<h2>Forma de Pagamento</h2>
						</div>
					</div>

					<div class="clear" data-gn-forma-pagamento="radio" data-gn-toggle="true">
						
						<div class="checkout-info pull-right">
							<div id="checkout-billet-option" data-gn-boleto>
								<div data-gn-boleto-imagem>
								</div>
								<div>
									<ul>
										<li>Você terá 3 dias consecutivos para efetuar o pagamento de seu boleto.</li>
										<li>O código de barras de seu boleto e um link para o mesmo serão exibidos ao finalizar a compra.</li>
										<li>Para sua comodidade, será enviado um e-mail com o link de seu boleto.</li>
									</ul>
								</div>
							</div>
							<div id="checkout-card-option" data-gn-cartao>
								<div class="checkout-select-card" data-gn-cartao-bandeiras="radio-imagem">
								</div>
								<div class="clear checkout-line">
									<div class="checkout-column-1 pull-left">
										<div class="checkout-input-title">
											Número do cartão de crédito:
										</div>
										<div class="checkout-input-div checkout-large1-input">
											<input id="numero-cartao" type="text" class="checkout-input-text checkout-large1-input" data-gn-cartao-numero />
										</div>
									</div>
									<div class="checkout-column-2 pull-left">
										<div class="checkout-input-title">
											Vencimento:
										</div>
										<div>
											<div class="checkout-input-div pull-left">
												<select id="mes-venc-cartao" class="checkout-input-select checkout-small-input" data-gn-cartao-mes>
													<option>Mês</option>
													<option>01</option>
													<option>02</option>
													<option>03</option>
													<option>04</option>
													<option>05</option>
													<option>06</option>
													<option>07</option>
													<option>08</option>
													<option>09</option>
													<option>10</option>
													<option>11</option>
													<option>12</option>
												</select>
											</div>
											<div class="checkout-input-div checkout-input-space pull-left">
												<select id="ano-venc-cartao" class="checkout-input-select checkout-small-input" data-gn-cartao-ano>
													<option>Ano</option>
													<option>2014</option>
													<option>2015</option>
													<option>2016</option>
													<option>2017</option>
													<option>2018</option>
													<option>2019</option>
													<option>2020</option>
													<option>2021</option>
													<option>2022</option>
													<option>2023</option>
													<option>2024</option>
													<option>2025</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="clear checkout-line">
									<div class="checkout-column-1 pull-left">
										<div class="checkout-input-title">
											Código de Segurança:
										</div>
										<div>
											<div class="checkout-input-div pull-left">
												<input type="text" class="checkout-input-text checkout-input-secury-item" data-gn-cartao-codigoSeguranca />
											</div>
											<div class="checkout-security-code pull-left">
												<div class="clear">
													<div class="pull-left checkout-security-code-tip">São os três últimos dígitos no verso do cartão.</div>
													<img src="images/icon-payment-card.png" class="pull-left icon" />
												</div>
											</div>
										</div>
									</div>
									<div class="checkout-column-2 pull-left">
										<div class="checkout-input-title">
											Número de Parcelas:
										</div>
										<div class="checkout-input-div pull-left checkout-large-input" data-gn-cartao-parcelas>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="checkout-user-form">
					<div class="clear">
						<div class="checkout-pass pull-left">
							2
						</div>
						<div class="pull-left">
							<h2>Seus Dados</h2>
						</div>
					</div>
					<div class="clear">
						<div class="checkout-info-user">
							<div class="clear">
								<div class="checkout-column-1 pull-left">
									<div class="checkout-input-title">
										Nome completo:
									</div>
									<div class="checkout-input-div checkout-grand-input">
										<input type="text" class="checkout-input-text checkout-grand-input" name="cliente-nome" id="cliente-nome" data-gn-cliente-nome />
									</div>
								</div>
								<div class="checkout-column-2 pull-left">
									<div class="checkout-input-title">
										E-mail:
									</div>
									<div class="checkout-input-div checkout-grand-input">
										<input type="text" class="checkout-input-text checkout-grand-input" name="cliente-email" id="cliente-email" onblur="verifyEmail(this)" data-gn-cliente-email />
									</div>
								</div>
							</div>
							<div class="clear checkout-line">
								<div class="checkout-column-1 pull-left">
									<div class="pull-left">
										<div class="checkout-input-title">
											CPF:
										</div>
										<div class="checkout-input-div checkout-mediun-input">
											<input type="text" id="cpf" name="cpf" class="checkout-input-text checkout-mediun-input" onblur="verifyCPF(this)" OnKeyUp="format('###.###.###-##', this);" maxlength="14" data-gn-cliente-cpf />
										</div>
									</div>
									<div class="pull-left checkout-input-space">
										<div class="checkout-input-title">
											Celular:
										</div>
										<div class="checkout-input-div checkout-mediun-input">
											<input type="text" name="celular" id="celular" class="checkout-input-text checkout-mediun-input" OnKeyUp="maskCel(this)"  data-gn-cliente-celular />
										</div>
									</div>
								</div>
								<div class="checkout-column-2 pull-left">
									<div class="checkout-input-title">
										Nascimento:
									</div>
									<div class="checkout-input-div checkout-mediun-input">
										<input type="text" name="date" id="date" class="checkout-input-text checkout-mediun-input" OnKeyUp="format('##/##/####', this);" maxlength="10" data-gn-cliente-nascimento />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="checkout-user-form">
					<div class="clear">
						<div class="checkout-pass pull-left">
							3
						</div>
						<div class="pull-left">
							<h2>Endereço de Entrega</h2>
						</div>
					</div>
					<div class="clear">
						<div class="checkout-info-user">
							<div class="clear">
								<div class="pull-left">
									<div class="checkout-input-title">
										CEP:
									</div>
									<div class="checkout-input-div">
										<input id="ent-cep" name="ent-cep" type="text" class="checkout-input-text checkout-mediun-input" OnKeyUp="format('#####-###', this)" maxlength="9" data-gn-endereco-entrega-cep <?php echo isset($_SESSION['cep_destination']) ? "value='".$_SESSION['cep_destination']."' disabled" : ''; ?> />
									</div>
								</div>
								<div class="pull-left checkout-input-space">
									<div class="checkout-input-title">
										Endereço:
									</div>
									<div class="checkout-input-div">
										<input id="ent-log" name="ent-log" type="text" class="checkout-input-text checkout-big-input" data-gn-endereco-entrega-logradouro />
									</div>
								</div>
								<div class="pull-left checkout-input-space">
									<div class="checkout-input-title">
										Número:
									</div>
									<div class="checkout-input-div">
										<input id="ent-num" name="ent-num" type="text" class="checkout-input-text checkout-small-input" data-gn-endereco-entrega-numero />
									</div>
								</div>
							</div>
							<div class="clear checkout-line">
								<div class="pull-left">
									<div class="checkout-input-title">
										Bairro:
									</div>
									<div class="checkout-input-div">
										<input id="ent-bai" name="ent-bai" type="text" class="checkout-input-text checkout-mediun-input" data-gn-endereco-entrega-bairro />
									</div>
								</div>
								<div class="pull-left checkout-input-space">
									<div class="checkout-input-title">
										Complemento e referência:
									</div>
									<div class="checkout-input-div">
										<input id="ent-com" name="ent-com" type="text" class="checkout-input-text checkout-large-input" data-gn-endereco-entrega-complemento />
									</div>
								</div>

								<div class="pull-left checkout-input-space">
									<div class="checkout-input-title">
										Cidade:
									</div>
									<div class="checkout-input-div">
										<input id="ent-cid" name="ent-cid" type="text" class="checkout-input-text checkout-mediun-input" data-gn-endereco-entrega-cidade />
									</div>
								</div>
								<div class="pull-left checkout-input-space">
									<div class="checkout-input-title">
										Estado:
									</div>
									<div class="checkout-input-div">
										<select id="ent-uf" name="ent-uf" class="checkout-input-select checkout-small-input" data-gn-endereco-entrega-estado>
											<option value="">Selecione</option>
											<option>AC</option>
											<option>AL</option>
											<option>AM</option>
											<option>AP</option>
											<option>BA</option>
											<option>CE</option>
											<option>DF</option>
											<option>ES</option>
											<option>GO</option>
											<option>MA</option>
											<option>MG</option>
											<option>MS</option>
											<option>MT</option>
											<option>PA</option>
											<option>PB</option>
											<option>PE</option>
											<option>PI</option>
											<option>PR</option>
											<option>RJ</option>
											<option>RN</option>
											<option>RO</option>
											<option>RR</option>
											<option>RS</option>
											<option>SC</option>
											<option>SE</option>
											<option>SP</option>
											<option>TO</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="same-address-block" data-gn-cartao>
						<label>
						<input type='checkbox' name='checkout-same-address' value='true' id="checkout-same-address" onclick="sameAddressChange()" checked/> 
							O endereço de cobrança é o mesmo da entrega.
						</label>
					</div>
				</div>

				<div id="checkout-billing-address">
					<div class="checkout-user-form" data-gn-cartao>
						<div class="clear">
							<div class="checkout-pass pull-left">
								4
							</div>
							<div class="pull-left">
								<h2>Endereço de Cobrança</h2>
							</div>
						</div>
						<div class="clear">
							<div class="checkout-info-user">
								<div class="clear">
									<div class="pull-left">
										<div class="checkout-input-title">
											CEP:
										</div>
										<div class="checkout-input-div">
											<input id="cob-cep" name="cob-cep" type="text" class="checkout-input-text checkout-mediun-input" OnKeyUp="format('#####-###', this)" maxlength="9" data-gn-endereco-cobranca-cep />
										</div>
									</div>
									<div class="pull-left checkout-input-space">
										<div class="checkout-input-title">
											Endereço:
										</div>
										<div class="checkout-input-div">
											<input id="cob-log" name="cob-log" type="text" class="checkout-input-text checkout-big-input" data-gn-endereco-cobranca-logradouro />
										</div>
									</div>
									<div class="pull-left checkout-input-space">
										<div class="checkout-input-title">
											Número:
										</div>
										<div class="checkout-input-div">
											<input id="cob-num" name="cob-num" type="text" class="checkout-input-text checkout-small-input" data-gn-endereco-cobranca-numero />
										</div>
									</div>
								</div>
								<div class="clear checkout-line">
									<div class="pull-left">
										<div class="checkout-input-title">
											Bairro:
										</div>
										<div class="checkout-input-div">
											<input id="cob-bai" name="cob-bai" type="text" class="checkout-input-text checkout-mediun-input" data-gn-endereco-cobranca-bairro />
										</div>
									</div>
									<div class="pull-left checkout-input-space">
										<div class="checkout-input-title">
											Complemento e referência:
										</div>
										<div class="checkout-input-div">
											<input id="cob-com" name="cob-com" type="text" class="checkout-input-text checkout-large-input" data-gn-endereco-cobranca-complemento />
										</div>
									</div>

									<div class="pull-left checkout-input-space">
										<div class="checkout-input-title">
											Cidade:
										</div>
										<div class="checkout-input-div">
											<input id="cob-cid" name="cob-cid" type="text" class="checkout-input-text checkout-mediun-input" data-gn-endereco-cobranca-cidade />
										</div>
									</div>
									<div class="pull-left checkout-input-space">
										<div class="checkout-input-title">
											Estado:
										</div>
										<div class="checkout-input-div">
											<select id="cob-uf" name="cob-uf" class="checkout-input-select checkout-small-input" data-gn-endereco-cobranca-estado>
												<option value="">Selecione</option>
												<option>AC</option>
												<option>AL</option>
												<option>AM</option>
												<option>AP</option>
												<option>BA</option>
												<option>CE</option>
												<option>DF</option>
												<option>ES</option>
												<option>GO</option>
												<option>MA</option>
												<option>MG</option>
												<option>MS</option>
												<option>MT</option>
												<option>PA</option>
												<option>PB</option>
												<option>PE</option>
												<option>PI</option>
												<option>PR</option>
												<option>RJ</option>
												<option>RN</option>
												<option>RO</option>
												<option>RR</option>
												<option>RS</option>
												<option>SC</option>
												<option>SE</option>
												<option>SP</option>
												<option>TO</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="checkout-footer clear">
					<div class="checkout-security pull-left">
						<img src="images/security.png" />
					</div>
					<div class="checkout-finalize pull-left">
						<div class="checkout-finalize-button" onclick="sendForm()">
							<div class="clear">
								<div class="pull-left">
									Efetuar Pagamento
								</div>
								<div class="pull-left checkout-finalize-button-divisor"></div>
								<div class="pull-left">
									<?php echo formatMoney(Cart::getTotalPriceWithTaxes()); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div id="validation-alert">
			<div id="validation-alert-box">
				<div class="clear">
					<div class="pull-left">
						<img src="images/alert-icon.png" class="validation-alert-img" />
					</div>
					<div class="pull-left validation-alert-column">
						<div class="title-validation-alert color-green">ATENÇÃO</div>
						<div id="text-validation-alert"></div>
						<div class="validation-alert-close">
							<a onclick="alertOff()">Fechar</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
			} else {
				header("location: ./");
			}
			include "includes/footer.inc.php"; 
		?>
	</body>
</html>