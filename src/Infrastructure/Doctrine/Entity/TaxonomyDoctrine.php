<?php

namespace App\Infrastructure\Doctrine\Entity;

use App\Infrastructure\Adapter\Repository\TaxonomyRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;

#[ORM\Entity(repositoryClass: TaxonomyRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap(['tag' => TagDoctrine::class, 'category' => CategoryDoctrine::class])]
#[ORM\Table(name: 'taxonomy')]
class TaxonomyDoctrine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Slug(fields: ['title'])]
    #[ORM\Column(length: 128, unique: true)]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
