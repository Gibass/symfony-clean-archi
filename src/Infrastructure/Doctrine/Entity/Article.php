<?php

namespace App\Infrastructure\Doctrine\Entity;

use App\Domain\Article\Entity\ArticleInterface;
use App\Domain\Article\Entity\TaxonomyInterface;
use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\Shared\Entity\DateEntityInterface;
use App\Domain\Shared\Entity\PublishEntityInterface;
use App\Infrastructure\Adapter\Repository\ArticleRepository;
use App\Infrastructure\Doctrine\Trait\EntityPublish;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: 'article')]
class Article implements ArticleInterface, PublishEntityInterface, DateEntityInterface, CrudEntityInterface
{
    use EntityPublish;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Slug(fields: ['title'])]
    #[ORM\Column(length: 100, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, length: 800, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?Category $category = null;

    #[ORM\JoinTable(name: 'articles_tags')]
    #[ORM\JoinColumn(name: 'article_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'tag_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'articles')]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): ArticleInterface
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

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Article
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?TaxonomyInterface $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getIdentifier(): string
    {
        return 'email';
    }

    public function addTags(array $tags): ArticleInterface
    {
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }

        return $this;
    }
}
