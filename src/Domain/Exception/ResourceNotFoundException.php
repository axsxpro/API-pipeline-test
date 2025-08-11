<?php

namespace App\Domain\Exception;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class ResourceNotFoundException extends RuntimeException implements ApiExceptionInterface {

    // constructeur parent Exception : public function __construct(string $message = "", int $code = 0, Throwable $previous = null)

    public function __construct(string $message = 'Resource not found.')
    {
        parent::__construct($message);
    }

    public function getCustomMessage(): string
    {
        return $this->message;
    }

    public function getCustomStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND; // 404
    }
}

