<?php

namespace App\Infrastructure\Doctrine\Entity;

use App\Domain\Article\Entity\TaxonomyInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;

#[ORM\Entity(repositoryClass: TaxonomyRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap(['tag' => Tag::class, 'category' => Category::class])]
class Taxonomy implements TaxonomyInterface
{
    #[ORM\Column(length: 255)]
    protected ?string $title;

    #[Slug(fields: ['title'])]
    #[ORM\Column(length: 128, unique: true)]
    protected ?string $slug;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(string $title = null, string $slug = null)
    {
        $this->title = $title;
        $this->slug = $slug;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
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
