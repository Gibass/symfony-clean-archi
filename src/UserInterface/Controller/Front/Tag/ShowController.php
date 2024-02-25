<?php

namespace App\UserInterface\Controller\Front\Tag;

use App\Domain\Tag\Exception\TagNotFoundException;
use App\Domain\Tag\Request\ListingRequest;
use App\Domain\Tag\UseCase\Listing;
use App\UserInterface\Presenter\Web\ListingTagPresenterHTML;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class ShowController
{
    #[Route('/tag/{slug}', name: 'tag_show')]
    public function showTag(string $slug, Request $request, Listing $listing, ListingTagPresenterHTML $presenter): Response
    {
        $page = (int) $request->query->get('page', 0);
        $request = new ListingRequest($slug, $page);

        try {
            return $listing->execute($request, $presenter);
        } catch (TagNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
