<?php

declare(strict_types=1);

namespace App\Article\UserInterface\DTO;

use App\Article\Domain\Model\Entity\Article;
use App\Article\Domain\Model\Enum\ArticleStatus;
use App\Core\Domain\Model\DTO\DTOEntityInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\ObjectMapper\Attribute\Map;

#[Map(target: Article::class)]
class ArticleDTO implements DTOEntityInterface
{
    public ?int $id = null;
    public ?string $title = null;
    public ?string $content = null;
    public Collection $taxonomies;
    public ?ArticleStatus $status = null;

    public function getClass(): string
    {
        return Article::class;
    }

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function getPrimaryValue(): ?int
    {
        return $this->id;
    }
}
