<?php

namespace App\Infrastructure\Test\Adapter;

use App\Domain\Article\Entity\Article;
use App\Domain\Article\Entity\Image;
use App\Domain\Article\Gateway\ArticleGatewayInterface;

class ArticleGateway implements ArticleGatewayInterface
{
    public function getById(int $id): ?Article
    {
        if ($id > 0) {
            $image = (new Image())->setTitle('Image Custom')->setPath('/02-2024/image-custom.jpg');

            return (new Article())
                ->setId($id)
                ->setTitle('Custom Title')
                ->setSlug('custom-article')
                ->setContent('Custom Content')
                ->setMainMedia($image)
                ->setCreatedAt(\DateTimeImmutable::createFromFormat('d/m/Y', '15/05/2023'))
                ->setPublishedAt(\DateTimeImmutable::createFromFormat('d/m/Y', '15/05/2023'))
            ;
        }

        return null;
    }

    public function getPublishedById(int $id): ?Article
    {
        return $this->getById($id);
    }
}
