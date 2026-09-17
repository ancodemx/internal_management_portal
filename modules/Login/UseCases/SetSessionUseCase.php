<?php

namespace modules\Login\UseCases;

use modules\Login\LoginService;

use app\Utils\JwtService as Jwt;
use app\Utils\AppResponse;

use app\Core\RedisHandler;

use app\Exceptions\ResponseException;

class SetSessionUseCase
{
    private LoginService $loginService;
    private Jwt $jwtService;
    private RedisHandler $redis;

    public function __construct() {
        $this->loginService = new LoginService();
        $this->jwtService = new Jwt();
        $this->redis = new RedisHandler();
    }

    public function execute(array $data) : array
    {
        try {
            // Guardamos los datos en la sesión
            // $_SESSION["token"] = md5(uniqid(mt_rand(), true));

            // Validamos que los datos no vengan vacíos o sean nulos
            if (empty($data['id']) || empty($data['profile_id']))
                throw new ResponseException("Los datos no deben estar vacíos.", 0, ["alert_type" => "error"], 400, false);

            $token = $this->jwtService->encode([
                'user_id' => $data['id'],
                'profile_id' => $data['profile_id']
            ], 15 * 60); // Expira en 15 minutos

            // Guardamos el token en Redis, expira en 12 horas
            // $refreshToken = bin2hex(random_bytes(32));
            // $this->redis->set('user_id:refreshToken:' . $data['id'], ['refreshToken' => $refreshToken], 43200);

            $_SESSION["token"] = $token;

            $_SESSION["user_data"] = $data;

            $_SESSION["profile_menu"] = $this->crear_menu( $data["profile_id"] );
            $_SESSION["permissions"] = json_decode( $this->loginService->findByPermissionsByProfile( $data["profile_id"] )['response'][0]['json_permissions'], true);

            // return ["is_error" => false, "code_error" => 0, "meta_data" => [], "http_status_code" => 201, "message" => "Acceso correcto.", "response" => ['session_on' => true]];
            return AppResponse::success(
                "Acceso correcto.",
                ["alert_type" => "success"],
                ['session_on' => true],
                201,
                0
            );
            

        } catch (\Throwable $e) {
            // Limpia recursos si es necesario
            // $this->transaction->rollback();
            // $this->transaction->closeConnection();
            throw $e; // <-- vuelve a lanzar la excepción
        }
    }

    # Menu Perfil Usuario
    public function crear_menu( int $profile_id ) : array
    {
        $items_childs = $this->loginService->findItemsMenuByProfileParent( $profile_id )['response'];

        // Validar que haya items hijos
        if (empty($items_childs))
            throw new ResponseException("No se encontraron items de menú para el perfil especificado.", 0, ["alert_type" => "error"], 404, false);
        
        $array = [];
        foreach( $items_childs as $item_child )
        {
            $level_path = json_decode($item_child['level_path'], true);
            
            foreach( $level_path as $id )
            { 
                $array[] = $this->loginService->findItemsMenuByProfileChild( $id )['response'][0];
            }
        }

        $tree = $this->buildTree($array);

        uasort($tree, function ($a, $b) {
            if ($a['sort_order'] == $b['sort_order']) {
                return 0;
            }
            return ($a['sort_order'] < $b['sort_order']) ? -1 : 1;
        }); 

        return $tree;
    }


    // Crea una función recursiva para construir el árbol
    public function buildTree($items, $parentId = NULL) : array
    {
        $tree = array();
        foreach ($items as $item) {
            if ($item['parent_menu_id'] == $parentId) {
                $children = $this->buildTree($items, $item['id']);
                if ($children) {
                    $item['child'] = $children;
                }
                $tree[$item['id']] = $item;
                // $tree[] = $item;
            }
        }
        return $tree;
    }

}