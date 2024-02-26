<?php

namespace App\UserInterface\Presenter\Web;

use App\Domain\Home\Presenter\ListingPresenterInterface as HomeListingPresenter;
use App\Domain\Home\Response\ListingResponse;
use App\Domain\Shared\Listing\Presenter\ListingPresenterInterface;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;

class ListingHomePresenterHTML extends AbstractWebPresenter implements ListingPresenterInterface, HomeListingPresenter
{
    /**
     * @throws \Exception
     */
    public function present(ListingResponse $response): Response
    {
        $pager = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $response->getAdapter(),
            $response->getCurrentPage(),
            $response->getMaxPerPage()
        );

        return $this->render('front/pages/home/listing.html.twig', [
            'pager' => $pager,
        ]);
    }
}
