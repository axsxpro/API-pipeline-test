<?php

namespace App\Application\DTO\RoleDto\Output;

class RoleResponseDto
{
    public function __construct(
        public string $name,
    ) {}
}