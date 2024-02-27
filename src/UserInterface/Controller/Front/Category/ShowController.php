<?php

namespace App\UserInterface\Controller\Front\Category;

use App\Domain\Category\Exception\CategoryNotFoundException;
use App\Domain\Category\Request\CategoryShowRequest;
use App\Domain\Category\UseCase\CategoryShow;
use App\UserInterface\Presenter\Web\CategoryShowPresenterHTML;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class ShowController
{
    #[Route('/category/{slug}', name: 'category_listing')]
    public function showCategory(string $slug, Request $request, CategoryShow $categoryShow, CategoryShowPresenterHTML $presenter): Response
    {
        $page = (int) $request->query->get('page', 0);
        $request = new CategoryShowRequest($slug, $page);

        try {
            return $categoryShow->execute($request, $presenter);
        } catch (CategoryNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
