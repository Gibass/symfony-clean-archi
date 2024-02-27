<?php

namespace App\Domain\Home\UseCase;

use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\Home\Presenter\HomePresenterInterface;
use App\Domain\Home\Request\HomeRequest;
use App\Domain\Home\Response\HomeResponse;
use App\Domain\Tag\Gateway\TagGatewayInterface;

readonly class Home
{
    public function __construct(
        private ArticleGatewayInterface $articleGateway,
        private CategoryGatewayInterface $categoryGateway,
        private TagGatewayInterface $tagGateway
    ) {
    }

    public function execute(HomeRequest $request, HomePresenterInterface $presenter): mixed
    {
        $adapter = $this->articleGateway->getPaginatedAdapter();
        $categories = $this->categoryGateway->getFacetCategories();
        $tags = $this->tagGateway->getPopularTag();
        $lastArticles = $this->articleGateway->getLastArticles();

        return $presenter->present(new HomeResponse(
            $adapter,
            $categories,
            $tags,
            $lastArticles,
            $request->getCurrentPage(),
            10
        ));
    }
}
