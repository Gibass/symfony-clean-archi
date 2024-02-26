<?php

namespace App\UserInterface\Presenter\Web;

use App\Domain\Category\Presenter\ListingPresenterInterface as CategoryListingPresenter;
use App\Domain\Category\Response\ListingResponse;
use App\Domain\Shared\Listing\Presenter\ListingPresenterInterface;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;

class ListingCategoryPresenterHTML extends AbstractWebPresenter implements ListingPresenterInterface, CategoryListingPresenter
{
    public function present(ListingResponse $response): Response
    {
        $pager = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $response->getAdapter(),
            $response->getCurrentPage(),
            $response->getMaxPerPage()
        );

        return $this->render('front/pages/category/listing.html.twig', [
            'pager' => $pager,
            'category' => $response->getCategory(),
        ]);
    }
}
