<?php

namespace App\UserInterface\Presenter\Web;

use App\Domain\Home\Presenter\HomePresenterInterface;
use App\Domain\Home\Response\HomeResponse;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;

class HomePresenterHTML extends AbstractWebPresenter implements HomePresenterInterface
{
    /**
     * @throws \Exception
     */
    public function present(HomeResponse $response): Response
    {
        $pager = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $response->getAdapter(),
            $response->getCurrentPage(),
            $response->getMaxPerPage()
        );

        return $this->render('front/pages/home/listing.html.twig', [
            'pager' => $pager,
        ]);
    }
}
