<?php
namespace app\Exceptions;

class ResourceNotFoundException extends HttpExceptionBase
{
    public function __construct(
        string $message = 'Recurso no encontrado',
        int $codeError = 0,
        array $meta = [],
        int $httpStatus = 400,
        mixed $response = null
    ) {
        parent::__construct($message, $codeError, $meta, $httpStatus, $response);
    }
}
