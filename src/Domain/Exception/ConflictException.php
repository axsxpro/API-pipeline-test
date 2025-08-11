<?php

namespace App\Domain\Exception;

use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class ConflictException extends RuntimeException implements ApiExceptionInterface
{
    public function __construct(string $message = 'Conflict.')
    {
        parent::__construct($message);
    }

    public function getCustomMessage(): string
    {
        return $this->message;
    }

    public function getCustomStatusCode(): int
    {
        return Response::HTTP_CONFLICT; //409
    }
}