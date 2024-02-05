<?php

namespace App\UserInterface\Presenter\Web;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

abstract class AbstractWebPresenter
{
    public function __construct(protected Environment $twig)
    {
    }

    protected function render(string $view, array $parameters = []): Response
    {
        $content = $this->twig->render($view, $parameters);

        return (new Response())->setContent($content);
    }
}
