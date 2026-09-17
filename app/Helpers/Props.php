<?php
// session_start();

class Props
{
	// --- creamos la variable donde se instanciará la clase "conectar"
    public $conexion;

	public function __construct()
	{
		// --- inicializamos la clase para conectarnos a la bd
        $this->conexion = ConexionBD::get_instance();
	}

	// Así lo llamaremos: $this->props->funcPrueba("ANCODE", "DESARROLLO WEB", "MAZATLAN");
	/* public function funcPrueba(...$params)
	{
		foreach ( $params as $params ){
			echo $params . '-';
		}
	} */


	// --- Seguridad de Datos
	// ----------------------------------------
	/* public function validarLogin($CVE_USUARIO)
	{
		$CVE_USUARIO = ( !empty($CVE_USUARIO) || $CVE_USUARIO!=null ) ? $CVE_USUARIO : 0 ;

		//$query = "CALL OBTENER_USUARIO('3','$CVE_USUARIO')";
		$query = "SELECT verificarAccesoUsuarioPorClave('$CVE_USUARIO') AS TIENE_ACCESO";
        $consulta = $this->conexion->query($query) or die ($this->conexion->error());
        $respuesta = $this->conexion->consulta_assoc($consulta);

		$acceso = ( $respuesta['TIENE_ACCESO'] == "true" ) ? true : false ;

        return $acceso;
	} */


	/**
	* @param $permisos (string) string numero de permiso asignado
	* @param $tipo_output (boleano) tipo de salida de la funcion para validar
	*/
	public function validarPermisos($parameters = array("permiso" => [], "tipo_output" => false))
	{
		$dataParameters = array(
			"permisos" => [], 
			"tipo_output" => false
		);

		$dataParameters = array_merge($dataParameters, $parameters);

		if ( in_array($dataParameters['permisos'], $_SESSION["data_session"]["permisos"]) === false )
			if ( $dataParameters['tipo_output'] ) {
				die(header("Location: " . RUTA_URL . $_SESSION["controlador"]));
			}else {
				return false;
			}
		else
			return true;
	}


	// public function outputMensajeJSON($msg, $status = 'error'){
	// 	$envioDatos["status"] = $status;
	// 	$envioDatos["msg"] = $msg;
	// 	die(json_encode($envioDatos));
	// }


	public function outputSession(){
		//session_start();
        session_unset();
        session_destroy();

		// Send `message` to the parent using the postMessage method on the window.parent reference.
		//echo "<script type='text/javascript'>window.parent.postMessage('closeSession', '*')</script>";

		die(header("Location: ".RUTA_URL.LOGOUT));
	}


	public function tituloControlador()
	{
		foreach ($_SESSION["data_session"]["menu_perfil"] as $val) {
			
			foreach ($val["Opcion"] as $val2)
			{
				if ( isset($val2["metodo"]) ){
					
					if ($val2["metodo"] == $_SESSION["controlador"]) {

						$nombre_modulo = $val2["texto"];
						$igual = 1;
					}
					if ( $igual == 1){ break 2; }
				}else {
					foreach ($val2["opcion"] as $val3) 
					{
						if ($val3["metodo"] == $_SESSION["controlador"]) {
							$nombre_modulo = $val3["texto"];
							$igual = 1;
						}
					}
					if ( $igual == 1){ break 2; }
				}
			}
		}
		return $nombre_modulo;
	}

	public function tipoConsulta($opc_tipo)
	{
		$tipo_consulta = match($opc_tipo){
            'L' => 'consulta_array',
            'C' => 'numero_registros',
            'U' => 'consulta_assoc'
        };

		return $tipo_consulta;
	}

	public function responseToFront($data = [])
	{
		$initial_data = [
			"status" => "error", 
			"msg" => "No data.", 
			"data" => [] // Otros valores dinámicos que necesitemos enviar al front
		];

		$send_data = array_merge($initial_data, $data);

		return $send_data;
	}

}

?>