<?php

namespace App\UserInterface\Presenter\Web;

use App\Domain\Category\Presenter\CategoryShowPresenterInterface as CategoryListingPresenter;
use App\Domain\Category\Response\CategoryShowResponse;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;

class CategoryShowPresenterHTML extends AbstractWebPresenter implements CategoryListingPresenter
{
    public function present(CategoryShowResponse $response): Response
    {
        $pager = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $response->getAdapter(),
            $response->getCurrentPage(),
            $response->getMaxPerPage()
        );

        return $this->render('front/pages/category/listing.html.twig', [
            'pager' => $pager,
            'category' => $response->getCategory(),
            'categories' => $response->getCategories(),
            'tags' => $response->getTags(),
            'lastArticles' => $response->getLastArticles(),
        ]);
    }
}
