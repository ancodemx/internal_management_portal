<?php
namespace app\Exceptions;

class ExceptionHandler
{
    public function handle(\Throwable $e): void
    {
        if (method_exists($e, 'render')) {
            $data = $e->render();

            http_response_code($data['http_status_code'] ?? 500);

            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => 'Error inesperado',
                'exception' => get_class($e),
                'details' => $e->getMessage()
            ]);
        }
    }
}
