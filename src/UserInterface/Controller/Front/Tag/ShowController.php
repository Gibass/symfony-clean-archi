<?php

namespace App\UserInterface\Controller\Front\Tag;

use App\Domain\Tag\Exception\TagNotFoundException;
use App\Domain\Tag\Request\TagShowRequest;
use App\Domain\Tag\UseCase\TagShow;
use App\UserInterface\Presenter\Web\TagShowTagPresenterHTML;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class ShowController
{
    #[Route('/tag/{slug}', name: 'tag_show')]
    public function showTag(string $slug, Request $request, TagShow $tagShow, TagShowTagPresenterHTML $presenter): Response
    {
        $page = (int) $request->query->get('page', 0);
        $request = new TagShowRequest($slug, $page);

        try {
            return $tagShow->execute($request, $presenter);
        } catch (TagNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
