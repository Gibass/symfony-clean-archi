<?php

namespace App\Domain\Security\Entity;

interface UserEntityInterface
{
    public function getId(): ?int;

    public function setId(?int $id): UserEntityInterface;

    public function getEmail(): ?string;

    public function setEmail(?string $email): UserEntityInterface;

    public function getFirstname(): ?string;

    public function setFirstname(?string $firstname): UserEntityInterface;

    public function getLastname(): ?string;

    public function setLastname(?string $lastname): UserEntityInterface;

    public function getPassword(): string;

    public function setPassword(?string $password): UserEntityInterface;

    public function isVerified(): bool;

    public function setIsVerified(bool $isVerified): UserEntityInterface;
}
