<?php

namespace App\Domain\Article\UseCase;

use App\Domain\Article\Exception\ArticleNotFoundException;
use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\Article\Presenter\ShowPresenterInterface;
use App\Domain\Article\Request\ShowRequest;
use App\Domain\Article\Response\ShowResponse;

class Show
{
    public function __construct(private ArticleGatewayInterface $gateway)
    {
    }

    /**
     * @throws ArticleNotFoundException
     */
    public function execute(ShowRequest $request, ShowPresenterInterface $presenter): mixed
    {
        $article = $this->gateway->getPublishedById($request->getId());

        if ($article === null) {
            throw new ArticleNotFoundException(sprintf('Article with id : %d not found.', $request->getId()));
        }

        $response = new ShowResponse($article);

        return $presenter->present($response);
    }
}
