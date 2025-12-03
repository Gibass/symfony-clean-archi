<?php

namespace App\Home\UserInterface\Presenter\Web;

use App\Core\UserInterface\Presenter\AbstractWebPresenter;
use Symfony\Component\HttpFoundation\Response;

class HomePresenterHTML extends AbstractWebPresenter
{
    public function present(): Response
    {
        return $this->render('pages/home/home.html.twig');
    }
}
