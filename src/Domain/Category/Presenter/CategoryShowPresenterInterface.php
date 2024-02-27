<?php

namespace App\Domain\Category\Presenter;

use App\Domain\Category\Response\CategoryShowResponse;

interface CategoryShowPresenterInterface
{
    public function present(CategoryShowResponse $response): mixed;
}
