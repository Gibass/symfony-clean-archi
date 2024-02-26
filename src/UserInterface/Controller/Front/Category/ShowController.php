<?php

namespace App\UserInterface\Controller\Front\Category;

use App\Domain\Category\Exception\CategoryNotFoundException;
use App\Domain\Category\Request\ListingRequest;
use App\Domain\Category\UseCase\CategoryListing;
use App\Domain\Shared\Listing\UseCase\ListingUseCase;
use App\UserInterface\Presenter\Web\ListingCategoryPresenterHTML;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class ShowController
{
    #[Route('/category/{slug}', name: 'category_listing')]
    public function showCategory(string $slug, Request $request, CategoryListing $listing, ListingUseCase $listingUseCase, ListingCategoryPresenterHTML $presenter): Response
    {
        $page = $request->query->get('page', 0);
        $request = new ListingRequest($slug, $page);

        try {
            return $listingUseCase->execute($request, $listing, $presenter);
        } catch (CategoryNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
