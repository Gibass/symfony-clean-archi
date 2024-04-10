<?php

namespace App\UserInterface\Extension\Twig;

use Pagerfanta\PagerfantaInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PagerInfo extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('pagerInfo', [$this, 'pagerInfo']),
        ];
    }

    public function pagerInfo(PagerfantaInterface $pager): string
    {
        if ($nbResult = $pager->getNbResults()) {
            $currentPage = $pager->getCurrentPage();
            $max = $pager->getMaxPerPage();
            $first = ($currentPage * $max) - ($max - 1);
            $last = min($currentPage * $max, $nbResult);

            return $first . ' - ' . $last . ' sur ' . $nbResult;
        }

        return '';
    }
}
