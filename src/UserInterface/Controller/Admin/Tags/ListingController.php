<?php

namespace App\UserInterface\Controller\Admin\Tags;

use App\Domain\CRUD\Request\ListingRequest;
use App\Domain\CRUD\UseCase\Listing;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use App\UserInterface\Presenter\Web\Admin\ListingAdminPresenterHTML;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListingController extends AbstractController
{
    #[Route('/admin/listing/tags', name: 'admin_listing_tags', methods: ['GET'])]
    public function listing(Request $request, Listing $listing, TagGatewayInterface $categoryGateway, ListingAdminPresenterHTML $presenterHTML): Response
    {
        $page = $request->query->getInt('page');
        $listingRequest = new ListingRequest(['add' => 'admin_create_tag'], $page);

        $presenterHTML->setTemplate('admin/pages/tags/listing.html.twig');

        return $listing->execute($listingRequest, $presenterHTML, $categoryGateway);
    }
}
