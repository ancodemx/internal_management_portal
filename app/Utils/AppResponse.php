<?php
namespace app\Utils;

class AppResponse
{
    public static function success(
        /* string $message = "Operación exitosa.",
        int $code_error = 0,
        array $meta_data = ["alert_type" => "success"],
        $response = null,
        int $http_status_code = 200 */
        string $message = "Operación exitosa.",
        array $meta_data = ["alert_type" => "success"],
        $response = null,
        int $http_status_code = 200,
        int $code_error = 0
    ): array {
        return [
            'is_error' => false,
            'code_error' => $code_error,
            'meta_data' => $meta_data,
            'http_status_code' => $http_status_code,
            'message' => $message,
            'response' => $response
        ];
    }

    public static function status_response(
        /* bool $is_error,
        int $code_error = 1,
        array $meta_data = [],
        int $http_status_code = 400,
        string $message,
        $response = null */
        $response = []
    ) {
        $data = [
            'is_error' => $response['is_error'],
            'code_error' => $response['code_error'],
            'meta_data' => $response['meta_data'],
            'http_status_code' => $response['http_status_code'],
            'message' => $response['message'],
            'response' => $response['response']
        ];
        header('Content-Type: application/json; charset=UTF-8');
		http_response_code($response['http_status_code']);

		echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public static function response(
        /* bool $is_error,
        int $code_error = 1,
        array $meta_data = [],
        int $http_status_code = 400,
        string $message,
        $response = null,
        bool $die = false */
        bool $is_error,
        string $message,
        int $code_error = 1,
        array $meta_data = [],
        int $http_status_code = 400,
        $response = null,
        bool $die = false
    ) {
        $data = [
            'is_error' => $is_error,
            'code_error' => $code_error,
            'meta_data' => $meta_data,
            'http_status_code' => $http_status_code,
            'message' => $message,
            'response' => $response
        ];
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code($http_status_code);

        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        if ($die) {
            die();
        }
    }
    
}