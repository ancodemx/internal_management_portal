<?php

namespace app\Core;

use app\Exceptions\DataStatusResponse;

class Controller
{
	public function view($vista, $datos = [])
	{
		// echo '../views/' . $vista . '.php';
		if (file_exists('../views/' . $vista . '.php'))
			require_once '../views/' . $vista . '.php';
		else
			die('La vista no existe.');
	}


	public function component($componente, $datos = [])
	{
		if (file_exists('../app/components/' . $componente . '.php'))
			require_once '../app/components/' . $componente . '.php';
		else
			die('El componente no existe.');
	}


	/* public function DataStatusResponse($response) {

		header('Content-Type: application/json; charset=UTF-8');
		http_response_code($response['http_status_code']);

		echo json_encode([
			'is_error'         => $response['is_error'],
			'code_error'       => $response['code_error'],
			'meta_data'        => $response['meta_data'],
			'http_status_code' => $response['http_status_code'],
			'message'          => $response['message'],
			'response'         => $response['response']
		], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		
	} */
	
}


?>