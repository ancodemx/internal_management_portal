<?php
namespace app\Exceptions;

class ResponseException extends HttpExceptionBase
{
    public function __construct(
        string $message = 'Error de respuesta',
        int $codeError = 0,
        array $meta = [],
        int $httpStatus = 400,
        mixed $response = null
    ) {
        parent::__construct($message, $codeError, $meta, $httpStatus, $response);
    }
}
