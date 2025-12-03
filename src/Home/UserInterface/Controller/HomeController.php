<?php

declare(strict_types=1);

namespace App\Home\UserInterface\Controller;

use App\Home\UserInterface\Presenter\Web\HomePresenterHTML;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(HomePresenterHTML $presenter): Response
    {
        return $presenter->present();
    }
}
