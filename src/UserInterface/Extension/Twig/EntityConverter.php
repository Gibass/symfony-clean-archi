<?php

namespace App\UserInterface\Extension\Twig;

use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class EntityConverter extends AbstractExtension
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('convert', [$this, 'convert']),
        ];
    }

    public function convert($entity): mixed
    {
        return $this->manager->getRepository($entity::class)->convert($entity);
    }
}
