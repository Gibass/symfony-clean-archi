<?php

namespace App\UserInterface\Controller\Admin\Category;

use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\CRUD\Request\ListingRequest;
use App\Domain\CRUD\UseCase\Listing;
use App\UserInterface\Presenter\Web\Admin\ListingAdminPresenterHTML;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListingController extends AbstractController
{
    #[Route('/admin/listing/categories', name: 'admin_listing_categories', methods: ['GET'])]
    public function listing(Request $request, Listing $listing, CategoryGatewayInterface $categoryGateway, ListingAdminPresenterHTML $presenterHTML): Response
    {
        $page = $request->query->getInt('page', 0);
        $listingRequest = new ListingRequest(['add' => 'admin_create_category'], $page);

        $presenterHTML->setTemplate('admin/pages/categories/listing.html.twig');

        return $listing->execute($listingRequest, $presenterHTML, $categoryGateway);
    }
}
