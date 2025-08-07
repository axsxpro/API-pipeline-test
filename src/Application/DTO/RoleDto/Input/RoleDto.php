<?php

namespace App\Application\DTO\RoleDto\Input;

use App\Domain\Enum\RoleEnum;
use Symfony\Component\Validator\Constraints as Assert;

class RoleDto
{
    public function __construct(

        #[Assert\NotBlank]
        public RoleEnum $name,
    ) {}

}