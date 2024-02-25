<?php

namespace App\UserInterface\Presenter\Web;

use App\Domain\Tag\Presenter\ListingPresenterInterface;
use App\Domain\Tag\Response\ListingResponse;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;

class ListingTagPresenterHTML extends AbstractWebPresenter implements ListingPresenterInterface
{
    public function present(ListingResponse $response): Response
    {
        $pager = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $response->getAdapter(),
            $response->getCurrentPage(),
            $response->getMaxPerPage()
        );

        return $this->render('front/pages/tag/listing.html.twig', [
            'tag' => $response->getTag(),
            'pager' => $pager,
        ]);
    }
}
