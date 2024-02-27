<?php

namespace App\UserInterface\Controller\Front\Home;

use App\Domain\Home\Request\HomeRequest;
use App\Domain\Home\UseCase\Home;
use App\UserInterface\Presenter\Web\HomePresenterHTML;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class HomeController
{
    #[Route('/', name: 'home_listing')]
    public function listing(Request $request, Home $home, HomePresenterHTML $presenter): Response
    {
        $page = (int) $request->query->get('page', 0);
        $request = new HomeRequest($page);

        return $home->execute($request, $presenter);
    }
}
