<?php

namespace App\UserInterface\Controller\Front\Home;

use App\Domain\Home\Request\ListingRequest;
use App\Domain\Home\UseCase\Listing;
use App\UserInterface\Presenter\Web\ListingHomePresenterHTML;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class ListingController
{
    #[Route('/', name: 'home_listing')]
    public function listing(Request $request, Listing $listing, ListingHomePresenterHTML $presenter): Response
    {
        $page = (int) $request->query->get('page', 0);
        $request = new ListingRequest($page);

        return $listing->execute($request, $presenter);
    }
}
