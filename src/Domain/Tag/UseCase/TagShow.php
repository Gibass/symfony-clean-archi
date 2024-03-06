<?php

namespace App\Domain\Tag\UseCase;

use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\Tag\Exception\TagNotFoundException;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use App\Domain\Tag\Presenter\TagShowPresenterInterface;
use App\Domain\Tag\Request\TagShowRequest;
use App\Domain\Tag\Response\TagShowResponse;

readonly class TagShow
{
    public function __construct(
        private ArticleGatewayInterface $articleGateway,
        private CategoryGatewayInterface $categoryGateway,
        private TagGatewayInterface $tagGateway
    ) {
    }

    /**
     * @throws TagNotFoundException
     */
    public function execute(TagShowRequest $request, TagShowPresenterInterface $presenter): mixed
    {
        $tag = $this->tagGateway->getBySlug($request->getSLug());

        if (!$tag) {
            throw new TagNotFoundException('slug', $request->getSLug());
        }

        $adapter = $this->tagGateway->getPaginatedAdapter(['id' => $tag->getId()]);
        $categories = $this->categoryGateway->getFacetCategories();
        $tags = $this->tagGateway->getPopularTag();
        $lastArticles = $this->articleGateway->getLastArticles();

        return $presenter->present(new TagShowResponse(
            $adapter,
            $tag,
            $categories,
            $tags,
            $lastArticles,
            $request->getCurrentPage(),
            10
        ));
    }
}
