<?php
/**
 * Created by PhpStorm.
 * User: João Henrique
 * Date: 02/09/2015
 * Time: 15:06
 */

/**
 * Class Request
 *
 * Classe responsavel pelas requisições _POST e _GET
 *
 * @package Nucleo\Core
 */
class NucleoRequests {

	const POST = 1;
	const GET = 2;

	/**
	 * Obtem post e get em uma unica requisição
	 *
	 * Se existir o mesmo index no get e no post, o valor do get sobressai
	 *
	 * @param bool $acao - Separar a ação da requisição
	 *
	 * @return array
	 */
	public static function get($acao = false) {
		$request = array("acao" => null, "dados" => array());

		// Pega os valores do _POST
		foreach ($_POST as $index => $valor) {
			// Define a ação
			if ($acao && $index == "acao") {
				$request["acao"] = $_POST['acao'];
			} else {
				$request["dados"][$index] = $valor;
			}
		}

		// Pega os valores do _GET
		foreach ($_GET as $index => $valor) {
			// Define a ação
			if ($acao && $index == "acao") {
				$request["acao"] = $_GET['acao'];
			} else {
				$request["dados"][$index] = $valor;
			}
		}

		// Passa o index dados para o array principal
		if ( ! $acao) {
			$request = $request["dados"];
		}

		return $request;
	}

	/**
	 * Enviar Requisição
	 *
	 * @param array|string $dados <p>
	 * Se este parametro for um array, os outros parametros serão ignorados e o indice url deve ser passado.
	 * Se for uma string, este parametro será a URL.
	 * </p>
	 * @param int $method self::POST ou self::GET
	 * @param array|string $data Parâmetros para envio. Um array ou um json em string
	 * @param bool $send_json Enviar os parâmetros como um JSON
	 * @param null $timeout Tempo de execução
	 * @param false $output_header Cabeçalhos de saída
	 * @param null $httpheader Cabeçalhos de envio junto à requisição
	 *
	 * @return string
	 * @throws Exception
	 */
	public static function send(
		$dados,
		int $method = self::POST,
		$data = [],
		bool $send_json = false,
		$timeout = null,
		$output_header = false,
		$httpheader = null
	) {
		if (is_array($dados)) {
			if ( ! isset($dados['url'])) {
				throw new Exception("A url é obrigatoria para Requisição");
			}

			$url           = $dados['url'];
			$method        = $dados['method'] ?? self::POST;
			$data          = $dados['data'] ?? [];
			$send_json     = $dados['send_json'] ?? false;
			$timeout       = $dados['timeout'] ?? null;
			$output_header = $dados['output_header'] ?? false;
			$httpheader    = $dados['httpheader'] ?? null;
		} else {
			$url = $dados;
		}

		$ch = curl_init();

		// Dados gerais
		$curlopt = array(
			CURLOPT_RETURNTRANSFER => 'true',
			CURLOPT_SSL_VERIFYPEER => 'false',
			CURLOPT_ENCODING       => "",
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_MAXREDIRS      => 10
		);

		// Retorna os cabeçalhos da requisição
		if ($output_header == true) {
			$curlopt[CURLOPT_HEADER] = 'true';
		}

		// Tempo limite para requisição
		if ($timeout != null) {
			$curlopt[CURLOPT_TIMEOUT_MS] = $timeout;
		} else {
			$curlopt[CURLOPT_TIMEOUT] = 120;
		}

		// Define se será enviado via POST ou GET
		if ($method == self::GET) {
			$curlopt[CURLOPT_CUSTOMREQUEST] = "GET";

			// Verifica se ja existe um get na URL
			$char = (substr_count($url, "?") == 0) ? "?" : "&";
			$url  = $url . $char . http_build_query($data);

		} else if ($method == self::POST) {
			if ($send_json && is_array($data)) {
				$data = json_encode($data);
			}

			$curlopt[CURLOPT_CUSTOMREQUEST] = "POST";
			$curlopt[CURLOPT_POSTFIELDS]    = $data;
		}

		if (is_array($httpheader) && count($httpheader) > 0) {
			// Aplica header enviado por parametro
			$curlopt[CURLOPT_HTTPHEADER] = $httpheader;
		} else if ($send_json) {
			// Converte para json caso informado e não header tenha sido passado
			$curlopt[CURLOPT_HTTPHEADER] = array('Content-Type: application/json', 'Content-Length: ' . strlen($data));
		}

		$curlopt[CURLOPT_URL] = $url;

		curl_setopt_array($ch, $curlopt);

		$result = curl_exec($ch);

		if (curl_errno($ch) && ! in_array(curl_errno($ch), [6, 28])) {
			Log::add('error', curl_errno($ch) . " - " . curl_error($ch) . " [Requisição em $url]");
		}

		curl_close($ch);

		return trim($result);
	}

	public static function getallheaders() {
		if ( ! function_exists('getallheaders')) {
			$headers = [];

			foreach ($_SERVER as $name => $value) {
				if (substr($name, 0, 5) == 'HTTP_') {
					$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
				}
			}

			return $headers;
		} else {
			return getallheaders();
		}
	}

	/**
	 * Verifica caracteres no inicio da string
	 *
	 * @param string $haystack
	 * @param string $needle
	 *
	 * @return bool
	 */
	public static function startsWith($haystack, $needle) {
		// search backwards starting from haystack length characters from the end
		return $needle === "" || strrpos($haystack, $needle, - strlen($haystack)) !== false;
	}

	/**
	 * Verifica caracteres no fim da string
	 *
	 * @param string $haystack
	 * @param string $needle
	 *
	 * @return bool
	 */
	public static function endsWith($haystack, $needle) {
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}
}