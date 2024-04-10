<?php

namespace App\UserInterface\Controller\Admin\User;

use App\Domain\CRUD\Request\ListingRequest;
use App\Domain\CRUD\UseCase\Listing;
use App\Domain\Security\Gateway\UserGatewayInterface;
use App\UserInterface\Presenter\Web\Admin\ListingAdminPresenterHTML;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListingController extends AbstractController
{
    #[Route('/admin/listing/users', name: 'admin_listing_users')]
    public function listing(Request $request, Listing $listing, UserGatewayInterface $gateway, ListingAdminPresenterHTML $presenter): Response
    {
        $page = $request->get('page', 0);
        $listingRequest = new ListingRequest([], $page);

        $presenter->setTemplate('admin/pages/users/listing.html.twig');

        return $listing->execute($listingRequest, $presenter, $gateway);
    }
}
