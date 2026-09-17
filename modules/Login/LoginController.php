<?php

use app\Core\Controller;
use app\Core\SessionManager;


// use modules\Login\LoginFactory;
use modules\Login\Factories\LoginFactory;
use modules\Login\Factories\UserFactory;

use modules\Login\UseCases\AuthenticateUserUseCase;
use modules\Login\UseCases\SetSessionUseCase;

use app\Utils\AppResponse;

use app\Exceptions\ExceptionHandler;

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class Login extends Controller
{
	private SessionManager $sessionManager;
	private AuthenticateUserUseCase $authenticateUserUseCase;
	private SetSessionUseCase $setSessionUseCase;

	public function __construct()
	{
		$this->sessionManager = new SessionManager();
		$this->authenticateUserUseCase = new AuthenticateUserUseCase();
		$this->setSessionUseCase = new SetSessionUseCase();
	}


	//Todo controlador debe tener un metodo index
	public function index(): void
	{
		$this->view('login/Login');
	}


	public function logIn()
	{
		try {
			// Factory para transformar el array de datos del usuario a un molde con los campos necesarios
			// Esto es para evitar enviar datos innecesarios a la sesión, mantenga la seguridad y los indices sean consistentes
			$login_data = LoginFactory::make($_POST);
			
			$user_data = $this->authenticateUserUseCase->execute($login_data);	
			if (!$user_data['is_error'])
				$user_data = $user_data['response'];

			// Factory para transformar el array de datos del usuario a un molde con los campos necesarios
			// Esto es para evitar enviar datos innecesarios a la sesión, mantenga la seguridad y los indices sean consistentes
			$user_array = UserFactory::make($user_data);

			$session_ready = $this->setSessionUseCase->execute($user_array);

			// Si la sesión se ha creado correctamente, redirigimos al usuario a la página principal
			// $this->DataStatusResponse($session_ready);
			return AppResponse::status_response($session_ready);

		} catch (\Throwable $e) {
			(new ExceptionHandler())->handle($e);
			exit;
		}
	}


	public function cerrar_sesion()
	{
		$this->sessionManager->close_session();
	}

}
