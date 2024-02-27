<?php

namespace App\Infrastructure\Doctrine\Entity;

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
class ArticleDoctrine
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

    #[ORM\ManyToOne]
    private ?MediaDoctrine $mainMedia = null;

    #[ORM\Column(type: Types::TEXT, length: 800, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?CategoryDoctrine $category = null;

    #[ORM\JoinTable(name: 'articles_tags')]
    #[ORM\JoinColumn(name: 'article_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'tag_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: TagDoctrine::class, inversedBy: 'articles')]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

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

    public function getMainMedia(): ?MediaDoctrine
    {
        return $this->mainMedia;
    }

    public function setMainMedia(?MediaDoctrine $mainMedia): static
    {
        $this->mainMedia = $mainMedia;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): ArticleDoctrine
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

    public function getCategory(): ?CategoryDoctrine
    {
        return $this->category;
    }

    public function setCategory(?CategoryDoctrine $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, TagDoctrine>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(TagDoctrine $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(TagDoctrine $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
