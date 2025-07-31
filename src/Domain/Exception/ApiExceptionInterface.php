<?php

namespace App\Domain\Exception;

interface ApiExceptionInterface
{
    public function getCustomMessage(): string;
    public function getCustomStatusCode(): int;
}