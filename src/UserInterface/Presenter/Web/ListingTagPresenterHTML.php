<?php

namespace App\UserInterface\Presenter\Web;

use App\Domain\Shared\Listing\Presenter\ListingPresenterInterface;
use App\Domain\Tag\Presenter\ListingPresenterInterface as TagListingPresenter;
use App\Domain\Tag\Response\ListingResponse;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;

class ListingTagPresenterHTML extends AbstractWebPresenter implements ListingPresenterInterface, TagListingPresenter
{
    public function present(ListingResponse $response): Response
    {
        $pager = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $response->getAdapter(),
            $response->getCurrentPage(),
            $response->getMaxPerPage()
        );

        return $this->render('front/pages/tag/listing.html.twig', [
            'pager' => $pager,
            'tag' => $response->getTag(),
        ]);
    }
}
