<?php
use app\Core\Controller;

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class ErrorPage extends Controller {

	private $controlador = "ErrorPage";
    private $carpeta_vista = "error_page";

	public function __construct() {

	}

	//Todo controlador debe tener un metodo index
	public function index() 
	{
        http_response_code(404);
		$this->view($this->carpeta_vista.'/Error404');
	}

}