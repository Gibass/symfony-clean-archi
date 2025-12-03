<?php

namespace App\Article\Domain\Model\Enum;

enum ArticleStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
}
