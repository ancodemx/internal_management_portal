<?php
namespace app\Exceptions;

use Exception;

abstract class HttpExceptionBase extends Exception
{
    protected int $httpStatus;
    protected int $codeError;
    protected array $meta;
    protected mixed $response;

    public function __construct(
        string $message = 'Error',
        int $codeError = 0,
        array $meta = [],
        int $httpStatus = 400,
        mixed $response = null
    ) {
        $this->codeError = $codeError;
        $this->httpStatus = $httpStatus;
        $this->meta = $meta;
        $this->response = $response;

        parent::__construct($message, $codeError);
    }

    public function render(): array
    {
        return [
            'is_error' => true,
            'code_error' => $this->codeError,
            'meta_data' => $this->meta,
            'http_status_code' => $this->httpStatus,
            'message' => $this->getMessage(),
            'response' => $this->response
        ];
        
    }

    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }
}
