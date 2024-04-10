<?php

namespace App\UserInterface\Controller\Admin\Article;

use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\CRUD\Request\ListingRequest;
use App\Domain\CRUD\UseCase\Listing;
use App\UserInterface\Presenter\Web\Admin\ListingAdminPresenterHTML;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class ListingController
{
    #[Route('/admin/listing/articles', name: 'admin_listing_articles')]
    public function listing(Request $request, Listing $listing, ArticleGatewayInterface $gateway, ListingAdminPresenterHTML $presenter): Response
    {
        $page = (int) $request->query->get('page', 0);
        $request = new ListingRequest([
            'add' => 'admin_create_article',
        ], $page);

        $presenter->setTemplate('admin/pages/articles/listing.html.twig');

        return $listing->execute($request, $presenter, $gateway);
    }
}
