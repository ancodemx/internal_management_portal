<?php

use app\Core\Controller;
use app\Core\Session;

use modules\Profile\UseCases\DataTableUseCase;
use modules\Profile\UseCases\CreateProfileUseCase;
use modules\Profile\UseCases\UpdateProfileUseCase;
use modules\Profile\UseCases\DeleteProfileUseCase;
use modules\Profile\UseCases\GetProfileUseCase;

use app\Utils\AppResponse;

use app\Exceptions\ExceptionHandler;

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class Profile extends Controller
{
	private CreateProfileUseCase $createProfileUseCase;
	private UpdateProfileUseCase $updateProfileUseCase;
	private DeleteProfileUseCase $deleteProfileUseCase;
	private DataTableUseCase $dataTableUseCase;
	private GetProfileUseCase $getProfileUseCase;

	public function __construct()
	{
		$this->createProfileUseCase = new CreateProfileUseCase();
		$this->updateProfileUseCase = new UpdateProfileUseCase();
		$this->deleteProfileUseCase = new DeleteProfileUseCase();
		$this->dataTableUseCase = new DataTableUseCase();
		$this->getProfileUseCase = new GetProfileUseCase();
	}


	//Todo controlador debe tener un metodo index
	public function index(): void
	{
		$this->view('profile/profileList');
	}


	public function create(): void
	{
		$data = array();

		// Datos para el formulario
		$data['forms_data'] = [
			'forms' => [
				'form1' => [
					'title' => 'Nuevo perfil',
					'button' => 'Guardar perfil',
					'action' => URL_PATH . 'profile/save',
					'method' => 'POST',
					'logical_name' => 'profile',
					'inputs_params' => [
						'profile_name' => [
							'type' => 'text',
							'label' => 'Nombre',
							'value' => '',
							'required' => true
						],
						'description' => [
							'type' => 'text',
							'label' => 'Descripción',
							'value' => '',
							'required' => true
						]
					]
				]
			],
			'list' => []
		];

		$this->view('profile/profileForm', $data);
	}


	public function edit( $parametrosURL ): void
	{
		$data = array();
		$inputs_params = [];

		$response = $this->getProfileUseCase->execute( intval($parametrosURL[0]) );
		Session::put('temp_profile_data', [$response['response']]);


		// Generamos los inputs de tipo checkbox para el formulario
		// Para módulos
		foreach ($response['response']['json_items'] as $key => $value) {
			$inputs_params[$key] = [
				'type' => 'checkbox',
				'label' => 'Ver módulo',
				'value' => $value
			];
		}

		// Para permisos
		foreach ($response['response']['json_permissions'] as $key => $value) {
			$inputs_params[$key] = [
				'type' => 'checkbox',
				'label' => ucfirst(str_replace('_', ' ', $key)),
				'value' => $value
			];
		}


		// Datos para el formulario
		$data['forms_data'] = [
			'forms' => [
				'form1' => [
					'title' => 'Editar perfil',
					'button' => 'Actualizar perfil',
					'action' => URL_PATH . 'profile/update',
					'method' => 'POST',
					'logical_name' => 'profile',
					'inputs_params' => [
						'profile_id' => [
							'type' => 'hidden',
							'value' => $response['response']['id'] ?? ''
						],
						'profile_name' => [
							'type' => 'text',
							'label' => 'Nombre',
							'value' => $response['response']['profile_name'] ?? '',
							'required' => true
						],
						'description' => [
							'type' => 'text',
							'label' => 'Descripción',
							'value' => $response['response']['description'] ?? '',
							'required' => true
						]
					]
				]
			],
			'list' => []
		];

		// Mezclamos inputs_params con los del formulario
		$data['forms_data']['forms']['form1']['inputs_params'] = array_merge(
			$data['forms_data']['forms']['form1']['inputs_params'],
			$inputs_params
		);

		$this->view('profile/profileForm', $data);
	}


	public function save()
	{
		try {

			// Manejamos POST ya que en el form utilizamos en los checkboxes en los atributos names array
			// Se tuvieron que hacer ajustes en el ajax para que los datos se envíen correctamente
			if( $_SERVER['REQUEST_METHOD'] == 'POST' )
			{
				// $postData = json_decode(file_get_contents("php://input"), true);
				// $_POST = array_merge($_POST, $postData);
				
				// Agrega el parámetro al array
				$_POST['user_action_id'] = $_SESSION['user_data']['id'];
				// print_r($_POST);
				// die();
				$response = $this->createProfileUseCase->execute($_POST);

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

			if( $_SERVER['REQUEST_METHOD'] == 'POST' )
			{
				// Leer y parsear los datos enviados por PUT
				// Esto es necesario porque los datos de un PUT no se envían en $_POST
				// parse_str(file_get_contents("php://input"), $_PUT);
				// $_POST = array_merge($_POST, $_PUT);

				// Agrega el parámetro al array
				$_POST['user_action_id'] = $_SESSION['user_data']['id'];

				$response = $this->updateProfileUseCase->execute($_POST);

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
				$response = $this->deleteProfileUseCase->execute($_POST);

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
	

}


