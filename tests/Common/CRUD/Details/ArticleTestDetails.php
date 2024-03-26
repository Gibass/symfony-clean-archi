<?php

namespace App\Tests\Common\CRUD\Details;

use App\Infrastructure\Doctrine\DataFixtures\ArticleTestFixtures;
use App\Tests\Common\CRUD\CrudTestDetails;

class ArticleTestDetails extends CrudTestDetails
{
    public static function dataTestCreateArticleSuccess(): \Generator
    {
        yield 'test_create_article_success' => [new self(
            '/admin/create/article',
            ['article[title]' => 'Custom Title Not blank with 25 char min'],
            [
                'success' => 'The article have been created successfully',
                'verifyCount' => '1 - 50 sur ' . (ArticleTestFixtures::NB_TOTAL + 1),
            ],
        )];
    }

    public static function dataTestCreateArticleFailed(): \Generator
    {
        yield 'test_create_article_empty_title' => [new self(
            '/admin/create/article',
            ['article[title]' => ''],
            ['error' => 'Value "" is blank, but was expected to contain a value.'],
        )];

        yield 'test_create_article_short_title' => [new self(
            '/admin/create/article',
            ['article[title]' => 'bad'],
            ['error' => 'Value "bad" is too short, it should have at least 25 characters, but only has 3 characters.'],
        )];

        yield 'test_create_article_long_title' => [new self(
            '/admin/create/article',
            ['article[title]' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, orci non maximus condimentum, magna ligula porta tellus, ac hendrerit lorem elit vitae urna. Cras eget tempus lectus. Nam sed dapibus leo. Aenean iaculis purus dui, at lobortis nunc.'],
            ['error' => 'Value "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, orci non maximus condim..." is too long, it should have no more than 255 characters, but has 256 characters.'],
        )];
    }
}
