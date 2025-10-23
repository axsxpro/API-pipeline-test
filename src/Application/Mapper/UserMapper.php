<?php

namespace App\Application\Mapper;

use App\Application\Dto\UserDto;
use App\Application\DTO\UserDto\Input\CreateUserDto;
use App\Application\DTO\UserDto\Output\UserResponseDto;
use App\Domain\Entity\User;
use DateTime;
use DateTimeImmutable;

class UserMapper
{
    public static function  mapEntityToDto(User $user): UserResponseDto
    {
        return new UserResponseDto(
            id: $user->getId(),
            email: $user->getEmail(),
            name: $user->getName(),
            firstname: $user->getFirstname(),
            birthdate: $user->getBirthdate()->format('d/m/Y'),
            role: $user->getRole()->getName()->value,
            createdAt: $user->getCreatedAt()->format('d-m-Y H:i:s')
        );
    }

    public static function mapCreateDtoToEntity(CreateUserDto $createUserDto): User
    {

        $user = new User();

        $user->setEmail($createUserDto->email);
        $user->setName($createUserDto->name);
        $user->setFirstname($createUserDto->firstname);
        $birthdate = DateTime::createFromFormat('d-m-Y', $createUserDto->birthdate);
        $user->setBirthdate($birthdate);
        $user->setCreatedAt(new DateTimeImmutable());

        return $user;
    }

}