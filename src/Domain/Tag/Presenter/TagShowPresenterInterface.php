<?php

namespace App\Domain\Tag\Presenter;

use App\Domain\Tag\Response\TagShowResponse;

interface TagShowPresenterInterface
{
    public function present(TagShowResponse $response): mixed;
}
