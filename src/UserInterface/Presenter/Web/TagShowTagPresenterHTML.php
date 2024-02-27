<?php

namespace App\UserInterface\Presenter\Web;

use App\Domain\Shared\Listing\Presenter\ListingPresenterInterface;
use App\Domain\Tag\Presenter\TagShowPresenterInterface as TagListingPresenter;
use App\Domain\Tag\Response\TagShowResponse;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;

class TagShowTagPresenterHTML extends AbstractWebPresenter implements TagListingPresenter
{
    public function present(TagShowResponse $response): Response
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
