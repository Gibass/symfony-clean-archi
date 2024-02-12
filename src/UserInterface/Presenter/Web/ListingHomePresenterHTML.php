<?php

namespace App\UserInterface\Presenter\Web;

use App\Domain\Home\Presenter\ListingPresenterInterface;
use App\Domain\Home\Response\ListingResponse;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;

class ListingHomePresenterHTML extends AbstractWebPresenter implements ListingPresenterInterface
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
