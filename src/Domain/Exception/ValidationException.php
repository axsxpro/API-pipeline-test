<?php

namespace App\Domain\Exception;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends RuntimeException implements ApiExceptionInterface
{
    public function __construct(string $message = 'Validation failed.')
    {
        parent::__construct($message);
    }

    public function getCustomMessage(): string
    {
        return $this->message;
    }

    public function getCustomStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST; // 400
    }
}