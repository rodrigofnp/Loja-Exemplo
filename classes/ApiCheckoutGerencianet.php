<?php

class ApiCheckoutGerencianet {

	private static $_URL = 'https://go.gerencianet.com.br/teste/api/checkout/pagar/xml';

	public static function gerarXMLPagamento(array $parametros) {

		$xml = '<?xml version="1.0" encoding="UTF-8"?><integracao>';
		$indice_erro = 1;

		$xml = self::addTagOpcional($xml, 'descricao', $parametros);

		if(isset($parametros['itens'])) {
			$xml .= "<itens>";

			foreach($parametros['itens'] as $index => $_item) {
				$item = "<item>";
				if(isset($_item['itemDescricao']) && isset($_item['itemValor'])) {
					$item .= "<itemDescricao>{$_item['itemDescricao']}</itemDescricao>";
					$item .= "<itemValor>{$_item['itemValor']}</itemValor>";

					$item = self::addTagOpcional($item, 'itemQuantidade', $_item);

				} else {
					throw new Exception("Erro: item {$index} não possui descrição ou valor", 2);
				}

				$xml .= $item . "</item>";
			}

			$xml .= "</itens>";
		}else {
			throw new Exception("Erro: itens não encontrado", $indice_erro++);
		}


		if(isset($parametros['retorno'])) {
			$retorno = '';

			$retorno = self::addTagOpcional($retorno, 'identificador', $parametros['retorno']);

			$retorno = self::addTagOpcional($retorno, 'urlNotificacao', $parametros['retorno']);

			if($retorno != '') {
				$xml  .= "<retorno>" . $retorno . "</retorno>";
			}
		}


		$xml = self::addTagOpcional($xml, 'desconto', $parametros);

		$xml = self::addTagOpcional($xml, 'frete', $parametros);

		$xml = self::addTagOpcional($xml, 'tipo', $parametros);

		if(isset($parametros['cliente'])) {
			$cliente = "<cliente>";

			$cliente = self::addTagObrigatoria($cliente, 'nome', $parametros['cliente'], $indice_erro++);
			$cliente = self::addTagObrigatoria($cliente, 'cpf', $parametros['cliente'], $indice_erro++);
			$cliente = self::addTagObrigatoria($cliente, 'email', $parametros['cliente'], $indice_erro++);
			$cliente = self::addTagObrigatoria($cliente, 'nascimento', $parametros['cliente'], $indice_erro++);
			$cliente = self::addTagObrigatoria($cliente, 'celular', $parametros['cliente'], $indice_erro++);

			$cliente .= "</cliente>";

			$xml .= $cliente;
		}else {
			throw new Exception("Erro: cliente não encontrado", $indice_erro++);
		}

		if(isset($parametros['enderecoEntrega'])) {
			$enderecoEntrega = '';

			$enderecoEntrega = self::addTagOpcional($enderecoEntrega, 'logradouro', $parametros['enderecoEntrega']);

			$enderecoEntrega = self::addTagOpcional($enderecoEntrega, 'numero', $parametros['enderecoEntrega']);

			$enderecoEntrega = self::addTagOpcional($enderecoEntrega, 'bairro', $parametros['enderecoEntrega']);

			$enderecoEntrega = self::addTagOpcional($enderecoEntrega, 'cidade', $parametros['enderecoEntrega']);

			$enderecoEntrega = self::addTagOpcional($enderecoEntrega, 'cep', $parametros['enderecoEntrega']);

			$enderecoEntrega = self::addTagOpcional($enderecoEntrega, 'estado', $parametros['enderecoEntrega']);

			$enderecoEntrega = self::addTagOpcional($enderecoEntrega, 'complemento', $parametros['enderecoEntrega']);

			if($enderecoEntrega != '') {
				$xml  .= "<enderecoEntrega>" . $enderecoEntrega . "</enderecoEntrega>";
			}
		}

		if(isset($parametros['formaPagamento'])) {
			$formaPagamento = "<formaPagamento>";

			if(isset($parametros['formaPagamento']['cartao'])) {
				$formaPagamento .= "<cartao>";
				$formaPagamento = self::addTagObrigatoria($formaPagamento, 'parcelas', $parametros['formaPagamento']['cartao'], $indice_erro++);

				if(isset($parametros['formaPagamento']['cartao']['enderecoCobranca'])) {
					$enderecoCobranca = '<enderecoCobranca>';
					$enderecoCobranca = self::addTagObrigatoria($enderecoCobranca, 'logradouro', $parametros['formaPagamento']['cartao']['enderecoCobranca'], $indice_erro++);
					$enderecoCobranca = self::addTagObrigatoria($enderecoCobranca, 'numero', $parametros['formaPagamento']['cartao']['enderecoCobranca'], $indice_erro++);
					$enderecoCobranca = self::addTagOpcional($enderecoCobranca, 'complemento', $parametros['formaPagamento']['cartao']['enderecoCobranca']);
					$enderecoCobranca = self::addTagObrigatoria($enderecoCobranca, 'bairro', $parametros['formaPagamento']['cartao']['enderecoCobranca'], $indice_erro++);
					$enderecoCobranca = self::addTagObrigatoria($enderecoCobranca, 'cidade', $parametros['formaPagamento']['cartao']['enderecoCobranca'], $indice_erro++);
					$enderecoCobranca = self::addTagObrigatoria($enderecoCobranca, 'estado', $parametros['formaPagamento']['cartao']['enderecoCobranca'], $indice_erro++);
					$enderecoCobranca = self::addTagObrigatoria($enderecoCobranca, 'cep', $parametros['formaPagamento']['cartao']['enderecoCobranca'], $indice_erro++);
					$formaPagamento .= $enderecoCobranca . '</enderecoCobranca>';
				} else {
					throw new Exception("Erro: enderecoCobranca não encontrado", $indice_erro++);
				}

				$formaPagamento .= "</cartao>";
			}else if(isset($parametros['formaPagamento']['boleto'])) {
				$formaPagamento .= "<boleto>";
				$formaPagamento = self::addTagObrigatoria($formaPagamento, 'vencimento', $parametros['formaPagamento']['boleto'], $indice_erro++);
				$formaPagamento .= "</boleto>";
			} else {
				throw new Exception("Erro: formaPagamento boleto ou cartao não encontrada", $indice_erro++);
			}
			

			$formaPagamento .= "</formaPagamento>";

			$xml .= $formaPagamento;
		}else {
			throw new Exception("Erro: formaPagamento não encontrada", $indice_erro++);
		}


		$xml .= "</integracao>";

		return $xml;
	}

	public static function pagar(array $parametros, $token, $tokenPagamento) {
		$xml = self::gerarXMLPagamento($parametros);
		$xml = str_replace(array("\n", "\r", "\t"), '', $xml);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::$_URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		$data = array("token" => $token, "tokenPagamento" => $tokenPagamento, "dados" => $xml);
		 
		curl_setopt($ch, CURLOPT_POST, true);
		 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		$response = curl_exec($ch);
		 
		curl_close($ch);

		return $response;
	}

	private static function addTagOpcional($xml, $tag, $parametros) {
		if(isset($parametros[$tag])) {
			$xml .= "<{$tag}>{$parametros[$tag]}</{$tag}>";
		}

		return $xml;
	}

	private static function addTagObrigatoria($xml, $tag, $parametros, $codigo_erro) {
		if(isset($parametros[$tag])) {
			$xml .= "<{$tag}>{$parametros[$tag]}</{$tag}>";
			return $xml;
		} else {
			throw new Exception("Erro: {$tag} não encontrado(a)", $codigo_erro);
		}

	}


}