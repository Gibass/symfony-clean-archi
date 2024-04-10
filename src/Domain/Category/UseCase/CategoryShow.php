<?php

namespace App\Domain\Category\UseCase;

use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\Category\Exception\CategoryNotFoundException;
use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\Category\Presenter\CategoryShowPresenterInterface;
use App\Domain\Category\Request\CategoryShowRequest;
use App\Domain\Category\Response\CategoryShowResponse;
use App\Domain\Tag\Gateway\TagGatewayInterface;

readonly class CategoryShow
{
    public function __construct(
        private ArticleGatewayInterface $articleGateway,
        private CategoryGatewayInterface $categoryGateway,
        private TagGatewayInterface $tagGateway
    ) {
    }

    /**
     * @throws CategoryNotFoundException
     */
    public function execute(CategoryShowRequest $request, CategoryShowPresenterInterface $presenter): mixed
    {
        $category = $this->categoryGateway->getBySlug($request->getSLug());

        if (!$category) {
            throw new CategoryNotFoundException('slug', $request->getSLug());
        }

        $adapter = $this->categoryGateway->getArticlePaginated($category->getId());
        $categories = $this->categoryGateway->getFacetCategories();
        $tags = $this->tagGateway->getPopularTag();
        $lastArticles = $this->articleGateway->getLastArticles();

        return $presenter->present(new CategoryShowResponse(
            $adapter,
            $category,
            $categories,
            $tags,
            $lastArticles,
            $request->getCurrentPage(),
            10
        ));
    }
}
