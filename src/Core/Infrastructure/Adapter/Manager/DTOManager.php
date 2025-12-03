<?php

namespace App\Core\Infrastructure\Adapter\Manager;

use App\Core\Domain\Manager\DTOManagerInterface;
use App\Core\Domain\Manager\EntityManagerInterface;
use App\Core\Domain\Model\DTO\DTOEntityInterface;
use App\Core\Domain\Model\DTO\DTOInterface;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

readonly class DTOManager implements DTOManagerInterface
{
    public function __construct(private ObjectMapperInterface $mapper, private EntityManagerInterface $entityManager)
    {
    }

    public function transform(?DTOInterface $value, array $context = []): mixed
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof DTOEntityInterface) {
            $repo = $this->entityManager->getRepository($value->getClass());
            $model = $repo->findOneBy([$value->getPrimaryKey() => $value->getPrimaryValue()]) ?? null;
        }


        return $this->mapper->map($value, $model ?? null);
    }

    public function createFrom(string $dtoClass, mixed $value,  array $context = []): DTOInterface
    {
        return $this->mapper->map($value, $dtoClass);
    }
}
