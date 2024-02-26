<?php

namespace App\Infrastructure\Doctrine\Entity;

use App\Infrastructure\Adapter\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ORM\Table(name: 'tag')]
class TagDoctrine extends TaxonomyDoctrine
{
}
