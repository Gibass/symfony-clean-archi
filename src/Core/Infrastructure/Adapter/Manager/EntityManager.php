<?php

namespace App\Core\Infrastructure\Adapter\Manager;

use App\Core\Domain\Manager\EntityManagerInterface;
use Doctrine\ORM\EntityManagerInterface as SymfonyEntityManager;
use Doctrine\ORM\EntityRepository;

readonly class EntityManager implements EntityManagerInterface
{
    public function __construct(private SymfonyEntityManager $entityManager)
    {
    }

    public function save($entity): void
    {
        if ($entity->id === null) {
            $this->entityManager->persist($entity);
        }
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function remove($entity): void
    {
        $this->entityManager->remove($entity);
    }

    public function getRepository(string $className): EntityRepository
    {
        return $this->entityManager->getRepository($className);
    }
}
