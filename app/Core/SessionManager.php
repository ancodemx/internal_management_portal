<?php

namespace app\Core;

use modules\User\UserRepository;

// use app\Exceptions\DataStatusResponse;
use app\Exceptions\ResponseException;
use app\Utils\AppResponse;

class SessionManager
{
	private $userRepository;

    public function __construct()
	{
		$this->userRepository = new UserRepository();
	}


	/*
	* @param $id_usuario (int) id del usuario a validar
	* @param $token (string) token de sesión a validar
	* @return void
	*/
    public function is_logged_in( int $id_usuario , string $token = '' ) : void
	{
		if ( empty($id_usuario) || $this->userRepository->isValidAccessById( $id_usuario ) == false )
            $this->close_session_login();
		
		if ( $token != $_SESSION["token"] || empty($_SESSION["token"]) )
            $this->close_session_login();
	}


    /* public function verify_token( $token = '' )
	{
		if ( $token == '' ){
			if ( empty($_SESSION["token"]) )
                $this->close_session_login();
		}else{
			if ( $token != $_SESSION["token"] || empty($_SESSION["token"]) )
                $this->close_session_login();
		}
	} */


	/**
	* @param $permisos (array) array de permisos asignados 
	* @param $tipo_output (int) tipo de salida de la funcion para validar  0 = Solo mensaje, 1 = Json de datos
	* @return void
	*/
	public function CheckPermission( array $parameters = [], int $tipo_output = 0 ) : void
	{
		$dataParameters = array(
			"permisos" => [], 
			"tipo_output" => false
		);

		$dataParameters = array_merge($dataParameters, $parameters);

		// Inicializamos una variable de bandera para rastrear si se encuentra algún valor
		$encontrado = false;

		// Recorremos el primer array
		foreach ($dataParameters['permisos'] as $valor) {
			// Si el valor existe en el segundo array, establecemos la bandera a true y salimos del bucle
			if ( in_array($valor, $_SESSION["permisos"]) ) {
				$encontrado = true;
				break;
			}
		}

		if ( $encontrado == false && $tipo_output == 1 )
			// throw new DataStatusResponse( true, 0, ['alert_type' => 'error'], 201, 'Permiso denegado.' );
			throw new ResponseException("Permiso denegado.", 0, ["alert_type" => "error"], 403, false);
		elseif ( $encontrado == false && $tipo_output == 0 )
			die('Permiso denegado');
	}


    public function close_session()
	{
		session_unset();
		session_destroy(); 

		// throw new DataStatusResponse( false, 0, ['session_on' => false], 201, 'Sesión cerrada.' );
		return AppResponse::status_response(
			['is_error' => false, 'code_error' => 0, 'meta_data' => ['session_on' => false], 'http_status_code' => 201, 'message' => 'Sesión cerrada.', 'response' => null]
		);
	}


	public function close_session_login()
	{
		session_unset();
		session_destroy(); 

		die(header("Location: " . URL_PATH . "login"));
	}

}