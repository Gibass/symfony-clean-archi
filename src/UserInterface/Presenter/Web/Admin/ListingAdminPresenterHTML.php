<?php

namespace App\UserInterface\Presenter\Web\Admin;

use App\Domain\CRUD\Presenter\ListingPresenterInterface;
use App\Domain\CRUD\Response\ListingResponse;
use App\UserInterface\Presenter\Web\AbstractWebPresenter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;
use Twig\TemplateWrapper;

class ListingAdminPresenterHTML extends AbstractWebPresenter implements ListingPresenterInterface
{
    private string|TemplateWrapper $template = 'admin/pages/listing/default.html.twig';

    public function present(ListingResponse $response): Response
    {
        $pager = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $response->getAdapter(),
            $response->getCurrentPage(),
            $response->getMaxPerPage()
        );

        return $this->render($this->template, [
            'pager' => $pager,
            'routes' => $response->getRoutes(),
        ]);
    }

    public function setTemplate(string|TemplateWrapper $template): static
    {
        $this->template = $template;

        return $this;
    }
}
