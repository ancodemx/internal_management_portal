<?php

namespace app\Core;

use app\Middleware\Kernel\MiddlewareHandler;

// ── Configuración de sesión ──────────────────────────────────────────────────
// Se establece ANTES de session_start() para que los cambios surtan efecto.
// SESSION_LIFETIME en .env controla el tiempo de vida (default: 7200 = 2 h).
$_rms_session_ttl = (int) ($_ENV['SESSION_LIFETIME'] ?? 7200);
ini_set('session.gc_maxlifetime', $_rms_session_ttl);
session_set_cookie_params([
    'lifetime' => $_rms_session_ttl,
    'path'     => '/',
    'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
    'samesite' => 'Lax',
]);
unset($_rms_session_ttl);
// ─────────────────────────────────────────────────────────────────────────────

session_start();

/*
Mapear la URL ingresada en el navegador
1. Controlador
2. Método
3. Parámetro
*/

class Core
{

	//Mientras no haya un controlador en la url carga $controladorActual, los mismo para metodo y parametros
	//Ejemplo: http://localhost/mvc_base/
	protected $currentController = 'Login';
	protected $currentMethod = 'index'; //En todo controlador debe de existir un método index
	protected $parameters = [];

	public function __construct()
	{
		// $middlewaresConfig = require __DIR__ . '/../config/middlewares.php';
		

		//Instanciamos metodo
		$url = $this->getUrl();
		$url[0] = isset($url[0]) ? $url[0] : '';

		$controllerName = (isset($url[0]) && !empty($url[0])) ? ucwords($url[0]) : $this->currentController;
		$methodName = $this->currentMethod;

		// Llama a la función para obtener los middlewares
        // $middlewaresToApply = $this->getMiddlewaresToApply($middlewaresConfig, $controllerName);

		//Si el controlador esta vacio me lleva al index en este caso el login
		if ($url[0] == "")
		{
			require_once '../modules/' . $this->currentController . '/' . $this->currentController . 'Controller.php';
			//y lo instanciamos
			$this->currentController = new $this->currentController();

			$currentMethod = $this->currentMethod;

            $middlewaresToApply = MiddlewareHandler::resolveMiddlewareList($controllerName, $methodName);

			$middlewareHandler = new MiddlewareHandler($middlewaresToApply);
            $middlewareHandler->handle(function () use ($methodName) {
                $this->currentController->{$methodName}();
            });
            
            // Ejecutar middlewares terminables después del controlador
            $middlewareHandler->terminate($controllerName, $methodName, []);
		}
		else
		{
			//echo ucwords($url[0] . 'Controller.php');
			//Buscar en controllers si el controlador existe
			if (file_exists('../modules/' . ucwords($url[0]) . '/' . ucwords($url[0] . 'Controller.php')))
			{

				//Si existe se configura como controlador por defecto
				$this->currentController = ucwords($url[0]);
				$_SESSION["controlador"] = $url[0];
				
				//unset indice, desmontamos el controlador por si seleccionamos otro deja de ser el controlador actual
				unset($url[0]);

				//requerir controlador
				require_once '../modules/' . $this->currentController . '/' . $this->currentController . 'Controller.php';

				$this->currentController = new $this->currentController();

				//Checar la segunda parte de la url que es el método
				//Si la url tiene un metodo

				if (isset($url[1]))
				{

					if (method_exists($this->currentController, $url[1]))
					{
						$this->currentMethod = $url[1];
						$currentMethod = $this->currentMethod;

						unset($url[1]);
					}
					else
					{
						$currentMethod = $this->currentMethod;
					}
				}
				else
				{
					$currentMethod = $this->currentMethod;
				}
				
				//echo $this->currentMethod;
				$methodName = $this->currentMethod;
				$_SESSION["metodo"] = $this->currentMethod;


				//Nota: el unset usado tanto en el controlador como en el metodo es para restar ambos indices es el array quedando asi:
				//Antes: Array ( [0] => login [1] => actualizar [2] => param1 [3] => param2 [4] => param3 )
				//Despues: Array ( [0] => param1 [1] => param2 [2] => param3 )
				//Con el fin de que solo queden los parametros en este caso

				//Checar la tercera parte, traer los parametros
				//array_values es para que en el caso si en la variable url exista un array
				$this->parameters = $url ? array_values($url) : [];
				//print_r($this->parameters);

				//Aquí lo que hacemos es que llamamos en este caso al controladorActual y clase a la vez que ya instanciamos arriba,
				//y al método con sus argumentos en este caso parametros
				// $this->currentController->$currentMethod($this->parameters);

				// $middlewaresToApply = MiddlewareHandler::resolveMiddlewareList($this->currentController, $methodName);
				$middlewaresToApply = MiddlewareHandler::resolveMiddlewareList($controllerName, $methodName);	

				$middlewareHandler = new MiddlewareHandler($middlewaresToApply);
				$middlewareHandler->handle(function () use ($methodName) {
					$this->currentController->{$methodName}($this->parameters);
				});
				
				// Ejecutar middlewares terminables después del controlador
				$middlewareHandler->terminate($controllerName, $methodName, $this->parameters);
			}
			else
			{
				$this->currentController = "ErrorPage";

				//requerir controlador
				//echo '../app/controllers/' . $this->currentController . 'Controller.php';
				require_once '../modules/' . $this->currentController . '/' . $this->currentController . 'Controller.php';
				//y lo instanciamos
				$this->currentController = new $this->currentController();

				$currentMethod = $this->currentMethod;
				// $this->currentController->$currentMethod();


				// Ejecutar middleware y luego el método
				$middlewaresToApply = MiddlewareHandler::resolveMiddlewareList($controllerName, $methodName);
				$middlewareHandler = new MiddlewareHandler($middlewaresToApply);
				$middlewareHandler->handle(function () use ($currentMethod) {
					// Aquí llamamos al método del controlador
					$this->currentController->$currentMethod();
				});
				
				// Ejecutar middlewares terminables después del controlador
				$middlewareHandler->terminate($controllerName, $methodName, []);
			}
		}

	}


	public function getUrl()
	{

		//la variable url dentro del get es la que recibimos en el .htaccess que esta dentro de /public

		//echo $_GET['url'];

		//si esta seteada la url
		if (isset($_GET['url']))
		{
			$url = rtrim($_GET['url'], '/');//quitamos los espacios que puedan tener
			$url = filter_var($url, FILTER_SANITIZE_URL);//
			$url = explode('/', $url);

			return $url;

		}

	}

}
