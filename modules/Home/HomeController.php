<?php

use app\Core\Controller;

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class Home extends Controller
{

	public function __construct()
	{

	}


	//Todo controlador debe tener un metodo index
	public function index(): void
	{
		$this->view('home/Home');
	}



}
