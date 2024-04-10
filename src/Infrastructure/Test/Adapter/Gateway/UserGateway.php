<?php

namespace App\Infrastructure\Test\Adapter\Gateway;

use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\Security\Entity\UserEntityInterface;
use App\Domain\Security\Gateway\UserGatewayInterface;
use App\Infrastructure\Doctrine\Entity\User;
use Pagerfanta\Adapter\AdapterInterface;

class UserGateway implements UserGatewayInterface
{
    public function register(array $data): UserEntityInterface
    {
        return (new User())
            ->setEmail($data['email'] ?? null)
            ->setPassword($data['password'] ?? null)
        ;
    }

    public function findByEmail(string $email): ?User
    {
        if ($email === 'used@mail.com') {
            return (new User())->setEmail($email);
        }

        if ($email === 'test@test.com') {
            return (new User())->setEmail($email)
                ->setIsVerified(true)
                ->setPassword('password')
            ;
        }

        return null;
    }

    public function validate(UserEntityInterface $user): void
    {
        $user->setIsVerified(true);
    }

    public function getByIdentifier(int|string $identifier): ?CrudEntityInterface
    {
        return (new User())
            ->setEmail($identifier)
            ->setEmail('test@test.com')
        ;
    }

    public function create(CrudEntityInterface $entity): CrudEntityInterface
    {
        return $entity->setId(1);
    }

    public function update(CrudEntityInterface $entity): CrudEntityInterface
    {
        return $entity;
    }

    public function delete(CrudEntityInterface $entity): bool
    {
        return true;
    }

    public function getPaginatedAdapter(array $conditions = []): AdapterInterface
    {
        return new class() implements AdapterInterface {
            private array $users = [];

            public function __construct()
            {
                foreach (range(1, 5) as $i) {
                    $this->users[] = (new User())
                        ->setId($i)
                        ->setEmail('test-' . $i . '@test.com')
                        ->setIsVerified(true)
                    ;
                }

                foreach (range(6, 8) as $i) {
                    $this->users[] = (new User())
                        ->setId($i)
                        ->setEmail('test-' . $i . '@test.com')
                        ->setIsVerified(true)
                        ->setRoles(['ROLE_ADMIN'])
                    ;
                }
            }

            public function getNbResults(): int
            {
                return \count($this->users);
            }

            public function getSlice(int $offset, int $length): iterable
            {
                return \array_slice($this->users, $offset, $length);
            }
        };
    }
}
