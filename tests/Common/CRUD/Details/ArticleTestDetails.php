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

    public static function dataTestUpdateArticleSuccess(): \Generator
    {
        yield 'test_update_article_success' => [new self(
            '/admin/edit/article/1',
            ['article[title]' => 'Custom Title updated with 25 char min'],
            [
                'success' => 'The article have been updated successfully',
                'defaultValues' => [
                    'article[title]' => 'Custom Title',
                ],
                'verifyElement' => 'Custom Title updated with 25 char min',
            ],
        )];
    }

    public static function dataTestUpdateArticleFailed(): \Generator
    {
        yield 'test_update_article_empty_title' => [new self(
            '/admin/edit/article/1',
            ['article[title]' => ''],
            ['error' => 'Value "" is blank, but was expected to contain a value.'],
        )];

        yield 'test_update_article_short_title' => [new self(
            '/admin/edit/article/1',
            ['article[title]' => 'bad'],
            ['error' => 'Value "bad" is too short, it should have at least 25 characters, but only has 3 characters.'],
        )];

        yield 'test_update_article_long_title' => [new self(
            '/admin/edit/article/1',
            ['article[title]' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, orci non maximus condimentum, magna ligula porta tellus, ac hendrerit lorem elit vitae urna. Cras eget tempus lectus. Nam sed dapibus leo. Aenean iaculis purus dui, at lobortis nunc.'],
            ['error' => 'Value "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, orci non maximus condim..." is too long, it should have no more than 255 characters, but has 256 characters.'],
        )];
    }

    public static function dataTestUpdateArticleNotFound(): \Generator
    {
        yield 'test_update_article_not_found' => [new self(
            '/admin/edit/article/0',
        )];
    }

    public static function dataTestDeleteArticleSuccess(): \Generator
    {
        yield 'test_delete_article_success' => [new self(
            '/admin/delete/article/1',
            [],
            [
                'success' => 'The article have been deleted successfully',
                'verifyCount' => '1 - 50 sur ' . (ArticleTestFixtures::NB_TOTAL - 1),
            ],
        )];
    }

    public static function dataTestDeleteArticleFailed(): \Generator
    {
        yield 'test_delete_article_failed' => [new self(
            '/admin/delete/article/10',
            [],
            [
                'error' => 'An error was occurred during deleting article',
            ],
        )];

        yield 'test_delete_article_not_found' => [new self(
            '/admin/delete/article/0',
            [],
            [
                'error' => 'The article with id 0 doesn\'t exist',
            ],
        )];
    }

    public static function dataTestDeleteArticleNotFound(): \Generator
    {
        yield 'test_delete_article_not_found' => [new self(
            '/admin/delete/article/0',
            [],
            [
                'error' => 'The article with id 0 doesn\'t exist',
            ],
        )];
    }
}
