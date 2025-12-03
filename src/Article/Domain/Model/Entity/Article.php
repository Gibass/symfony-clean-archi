<?php

declare(strict_types=1);

namespace App\Article\Domain\Model\Entity;

use App\Article\Domain\Model\Enum\ArticleStatus;
use App\Article\Infrastructure\Adapter\Repository\ArticleRepository;
use App\Taxonomy\Domain\Model\Entity\Taxonomy;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    public ?string $title = null;

    #[ORM\Column(type: 'text')]
    public ?string $content;

    #[ORM\Column(type: 'string', length: 25, enumType: ArticleStatus::class)]
    public ?ArticleStatus $status;

    #[ORM\ManyToMany(targetEntity: Taxonomy::class)]
    public Collection $taxonomies;

    public function __construct()
    {
        $this->taxonomies = new ArrayCollection();
    }
}
