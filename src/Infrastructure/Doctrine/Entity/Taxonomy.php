<?php

namespace App\Infrastructure\Doctrine\Entity;

use App\Domain\Article\Entity\TaxonomyInterface;
use App\Domain\CRUD\Entity\CrudEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TaxonomyRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap(['tag' => Tag::class, 'category' => Category::class])]
class Taxonomy implements TaxonomyInterface, CrudEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('main')]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('main')]
    protected ?string $title;

    #[Slug(fields: ['title'])]
    #[ORM\Column(length: 128, unique: true)]
    #[Groups('main')]
    protected ?string $slug;

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

    public function setTitle(?string $title): static
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

    public function getIdentifier(): string
    {
        return 'slug';
    }
}
