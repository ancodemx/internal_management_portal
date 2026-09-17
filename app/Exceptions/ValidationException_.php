<?php
namespace app\Exceptions;

class ValidationException extends HttpExceptionBase
{
    protected array $errors;

    public function __construct(
        string $message = 'Datos inválidos',
        int $codeError = 0,
        array $meta = [],
        int $httpStatus = 400,
        mixed $errors = null
    ) {
        $this->errors = $errors;
        parent::__construct($message, $codeError, $meta, $httpStatus, $errors);
    }

    public function render(): array
    {
        return array_merge(parent::render(), [
            'errors' => $this->errors
        ]);
    }
}
