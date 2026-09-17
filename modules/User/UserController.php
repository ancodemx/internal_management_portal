<?php

use app\Core\Controller;
use app\Core\Session;

// use modules\User\Factories\DataTableFactory;
// use modules\User\Factories\UserFactory;

use modules\User\UseCases\dataTableUseCase;
use modules\Profile\UseCases\CatalogueUseCase AS CatalogueUseCaseProfile;
use modules\Category\UseCases\CatalogueUseCase AS CatalogueUseCaseCategory;
use modules\User\UseCases\CreateUserUseCase;
use modules\User\UseCases\UpdateUserUseCase;
use modules\User\UseCases\DeleteUserUseCase;
use modules\User\UseCases\GetUserUseCase;

use app\Utils\AppResponse;

use app\Exceptions\ExceptionHandler;

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class User extends Controller
{
	private dataTableUseCase $dataTableUseCase;
	private CatalogueUseCaseProfile $catalogueUseCaseProfile;
	private CatalogueUseCaseCategory $catalogueUseCaseCategory;
	private CreateUserUseCase $createUserUseCase;
	private UpdateUserUseCase $updateUserUseCase;
	private DeleteUserUseCase $deleteUserUseCase;
	private GetUserUseCase $getUserUseCase;

	public function __construct()
	{
		$this->dataTableUseCase = new dataTableUseCase();
		$this->catalogueUseCaseProfile = new CatalogueUseCaseProfile();
		$this->catalogueUseCaseCategory = new CatalogueUseCaseCategory();
		$this->createUserUseCase = new CreateUserUseCase();
		$this->updateUserUseCase = new UpdateUserUseCase();
		$this->deleteUserUseCase = new DeleteUserUseCase();
		$this->getUserUseCase = new GetUserUseCase();
	}


	//Todo controlador debe tener un metodo index
	public function index(): void
	{
		$this->view('user/userList');
	}


	public function create(): void
	{
		// echo "<pre>";
		// print_r($_SESSION);
		// echo "</pre>";
		$data = array();
		$list = array();

		$list = $this->listCatalogs();

		/* $data_test = [
			'first_name' => 'Test User',
			'last_name' => 'User',
			'middle_name' => 'Middle',
			'email' => 'testuser@example.com',
			'username' => 'testuser',
			'password' => 'Alfonso1983!',
			'confirm_password' => 'Alfonso1983!',
			'profile_id' => 2,
			'json_categories' => json_encode([1, 2])
		]; */

		// Datos para el formulario
		$data['forms_data'] = [
			'forms' => [
				'form1' => [
					'title' => 'Nuevo usuario',
					'button' => 'Guardar usuario',
					'action' => URL_PATH . 'user/save',
					'method' => 'POST',
					'logical_name' => 'user',
					'inputs_params' => [
						'first_name' => [
							'type' => 'text',
							'label' => 'Nombre',
							'value' => '',
							'required' => true
						],
						'last_name' => [
							'type' => 'text',
							'label' => 'Apellido',
							'value' => '',
							'required' => true
						],
						'middle_name' => [
							'type' => 'text',
							'label' => 'Segundo Nombre',
							'value' => '',
							'required' => false
						],
						'email' => [
							'type' => 'email',
							'label' => 'Correo Electrónico',
							'value' => '',
							'required' => true
						],
						'username' => [
							'type' => 'text',
							'label' => 'Nombre de Usuario',
							'value' => '',
							'required' => true
						],
						'password' => [
							'type' => 'password',
							'label' => 'Contraseña',
							'value' => '',
							'required' => true
						],
						'confirm_password' => [
							'type' => 'password',
							'label' => 'Confirmar Contraseña',
							'value' => '',
							'required' => true
						],
						'profile_id' => [
							'type' => 'select',
							'label' => 'Perfil',
							'value' => '',
							'options' => $list['profiles'] ?? [],
							'required' => true
						],
						'json_categories' => [
							'type' => 'select',
							'label' => 'Categorías',
							'value' => '',
							'options' => $list['categories'] ?? [],
							'multiple' => true,
							'required' => true
						]
					]
				]
			],
			'list' => $list
		];

		$this->view('user/userForm2', $data);
	}


	public function edit( $parametrosURL ): void
	{
		$data = array();
		$list = array();

		$list = $this->listCatalogs();

		$response = $this->getUserUseCase->execute( intval($parametrosURL[0]) );
		Session::put('temp_user_data', [$response['response']]);

		// Datos para el formulario
		$data['forms_data'] = [
			'forms' => [
				'form1' => [
					'title' => 'Editar usuario',
					'button' => 'Actualizar usuario',
					'action' => URL_PATH . 'user/update',
					'method' => 'PUT',
					'logical_name' => 'user',
					'inputs_params' => [
						'user_id' => [
							'type' => 'hidden',
							'value' => $response['response']['id'] ?? ''
						],
						'first_name' => [
							'type' => 'text',
							'label' => 'Nombre',
							'value' => $response['response']['first_name'] ?? '',
							'required' => true
						],
						'last_name' => [
							'type' => 'text',
							'label' => 'Apellido',
							'value' => $response['response']['last_name'] ?? '',
							'required' => true
						],
						'middle_name' => [
							'type' => 'text',
							'label' => 'Segundo Nombre',
							'value' => $response['response']['middle_name'] ?? '',
							'required' => false
						],
						'email' => [
							'type' => 'email',
							'label' => 'Correo Electrónico',
							'value' => $response['response']['email'] ?? '',
							'required' => true
						],
						'username' => [
							'type' => 'text',
							'label' => 'Nombre de Usuario',
							'value' => $response['response']['username'] ?? '',
							'required' => true
						],
						'password' => [
							'type' => 'password',
							'label' => 'Contraseña',
							'value' => $response['response']['password'] ?? '',
							'required' => false
						],
						'confirm_password' => [
							'type' => 'password',
							'label' => 'Confirmar Contraseña',
							'value' => $response['response']['confirm_password'] ?? '',
							'required' => false
						],
						'profile_id' => [
							'type' => 'select',
							'label' => 'Perfil',
							'value' => $response['response']['profile_id'] ?? '',
							'options' => $list['profiles'] ?? [],
							'required' => true
						],
						'json_categories' => [
							'type' => 'select',
							'label' => 'Categorías',
							'value' => $response['response']['json_categories'] ?? [],
							'options' => $list['categories'] ?? [],
							'multiple' => true,
							'required' => true
						]
					]
				]
			],
			'list' => $list
		];

		$this->view('user/userForm2', $data);
	}


	public function save()
	{
		try {

			if( $_SERVER['REQUEST_METHOD'] == 'POST' )
			{
				// Agrega el parámetro al array
				$_POST['user_action_id'] = $_SESSION['user_data']['id'];

				// Crea el molde del usuario
				// $user_post_data = UserFactory::make($_POST);

				$response = $this->createUserUseCase->execute($_POST, true, true);

				return AppResponse::status_response($response);

			}else{
				header("Allow: POST");
				return AppResponse::response(true, "Method Not Allowed", 1, ['alert_type' => 'error'], 405, null);
			}

		} catch (\Throwable $e) {
			(new ExceptionHandler())->handle($e);
			exit;
		}
	}


	public function update()
	{
		try {

			if( $_SERVER['REQUEST_METHOD'] == 'PUT' )
			{
				// Leer y parsear los datos enviados por PUT
				// Esto es necesario porque los datos de un PUT no se envían en $_POST
				parse_str(file_get_contents("php://input"), $_PUT);
				$_POST = array_merge($_POST, $_PUT);

				// Agrega el parámetro al array
				$_POST['user_action_id'] = $_SESSION['user_data']['id'];

				$response = $this->updateUserUseCase->execute($_POST);

				return AppResponse::status_response($response);

			}else{
				header("Allow: PUT");
				return AppResponse::response(true, "Method Not Allowed", 1, ['alert_type' => 'error'], 405, null);
			}

		} catch (\Throwable $e) {
			(new ExceptionHandler())->handle($e);
			exit;
		}
	}


	public function delete()
	{
		try {

			if( $_SERVER['REQUEST_METHOD'] == 'DELETE' )
			{
				// Leer y parsear los datos enviados por DELETE
				// Esto es necesario porque los datos de un DELETE no se envían en $_POST
				parse_str(file_get_contents("php://input"), $_DELETE);
				$_POST = array_merge($_POST, $_DELETE);

				// Agrega el parámetro al array
				$_POST['user_action_id'] = $_SESSION['user_data']['id'];
				$response = $this->deleteUserUseCase->execute($_POST);

				return AppResponse::status_response($response);

			}else{
				header("Allow: DELETE");
				return AppResponse::response(true, "Method Not Allowed", 1, ['alert_type' => 'error'], 405, null);
			}

		} catch (\Throwable $e) {
			(new ExceptionHandler())->handle($e);
			exit;
		}
	}


	public function data_table_list()
	{
		try {

			if( $_SERVER['REQUEST_METHOD'] == 'POST' )
			{
				// $datatable_params = DataTableFactory::make($_POST);

				$response = $this->dataTableUseCase->execute($_POST);
				
				echo json_encode($response['response']);

			}else{
				header("Allow: POST");
				return AppResponse::response(true, "Method Not Allowed", 1, ['alert_type' => 'error'], 405, null);
			}

		} catch (\Throwable $e) {
			(new ExceptionHandler())->handle($e);
			exit;
		}
	}


	public function listCatalogs()
	{
		$list = array();

		$list['profiles'] = $this->catalogueUseCaseProfile->execute([])['response'] ?? [];
		$list['categories'] = $this->catalogueUseCaseCategory->execute([])['response'] ?? [];

		return $list;
	}

}


/*

Me ayudas a generar un componente form en php puro.

Por ejemplo Yo tengo una vista que se llama userList.php y en esa vista tengo un botón que dice "Nuevo" y quiero que al hacer click en ese botón me abra un modal con un formulario para crear un nuevo usuario.
El formulario debe tener los siguientes campos:
- Nombre completo
- Correo electrónico
- Contraseña
- Confirmar contraseña
- Perfil (select con opciones: Administrador, Usuario)

El modal debe tener un botón para guardar los datos y otro para cancelar.
El formulario debe validar que los campos no estén vacíos y que las contraseñas coincidan

Tener una carpeta con el nombre components y alli tener el archivo FormUser.php
El modal debe tener un id "modalFormUser" y el formulario debe tener un id "formUser".
En FormUser.php debes tener el código HTML del formulario y JS para manejar el envío del formulario y la validación de los campos.

La idea es que si necesito desde otra vista mandar llamar el formulario de usuario, pueda hacerlo fácilmente incluyendo el componente FormUser.php.
Y este ya no tenga que repetir el código del formulario en cada vista.

*/