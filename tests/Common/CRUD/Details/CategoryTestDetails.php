<?php

namespace App\Tests\Common\CRUD\Details;

use App\Infrastructure\Doctrine\DataFixtures\TaxonomyTestFixtures;
use App\Tests\Common\CRUD\CrudTestDetails;

class CategoryTestDetails extends CrudTestDetails
{
    public static function dataTestCreateCategorySuccess(): \Generator
    {
        yield 'test_create_category_success' => [new self(
            '/admin/create/category',
            ['category[title]' => 'Custom Category'],
            [
                'success' => 'The category have been created successfully',
                'verifyCount' => '1 - 3 sur ' . (TaxonomyTestFixtures::CAT_NB_TOTAL + 1),
            ],
        )];
    }

    public static function dataTestCreateCategoryFailed(): \Generator
    {
        yield 'test_create_category_empty_title' => [new self(
            '/admin/create/category',
            ['category[title]' => ''],
            ['error' => 'Value "" is blank, but was expected to contain a value.'],
        )];

        yield 'test_create_category_long_title' => [new self(
            '/admin/create/category',
            ['category[title]' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, orci non maximus condimentum, magna ligula porta tellus, ac hendrerit lorem elit vitae urna. Cras eget tempus lectus. Nam sed dapibus leo. Aenean iaculis purus dui, at lobortis nunc.'],
            ['error' => 'Value "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, orci non maximus condim..." is too long, it should have no more than 255 characters, but has 256 characters.'],
        )];
    }

    public static function dataTestUpdateCategorySuccess(): \Generator
    {
        yield 'test_update_category_success' => [new self(
            '/admin/edit/category/2',
            ['category[title]' => 'Custom Title updated with 25 char min'],
            [
                'success' => 'The category have been updated successfully',
                'defaultValues' => [
                    'category[title]' => 'Empty Cat',
                ],
                'verifyElement' => 'Custom Title updated with 25 char min',
            ],
        )];
    }

    public static function dataTestUpdateCategoryFailed(): \Generator
    {
        yield 'test_update_category_empty_title' => [new self(
            '/admin/edit/category/2',
            ['category[title]' => ''],
            ['error' => 'Value "" is blank, but was expected to contain a value.'],
        )];

        yield 'test_update_category_long_title' => [new self(
            '/admin/edit/category/2',
            ['category[title]' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, orci non maximus condimentum, magna ligula porta tellus, ac hendrerit lorem elit vitae urna. Cras eget tempus lectus. Nam sed dapibus leo. Aenean iaculis purus dui, at lobortis nunc.'],
            ['error' => 'Value "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, orci non maximus condim..." is too long, it should have no more than 255 characters, but has 256 characters.'],
        )];
    }

    public static function dataTestUpdateCategoryNotFound(): \Generator
    {
        yield 'test_update_category_not_found' => [new self(
            '/admin/edit/category/0',
        )];
    }

    public static function dataTestDeleteCategorySuccess(): \Generator
    {
        yield 'test_delete_category_success' => [new self(
            '/admin/delete/category/2',
            [],
            [
                'success' => 'The category have been deleted successfully',
                'verifyCount' => '1 - 1 sur ' . (TaxonomyTestFixtures::CAT_NB_TOTAL - 1),
            ],
        )];
    }

    public static function dataTestDeleteCategoryFailed(): \Generator
    {
        yield 'test_delete_category_failed' => [new self(
            '/admin/delete/category/10',
            [],
            [
                'error' => 'An error was occurred during deleting category',
            ],
        )];

        yield 'test_delete_category_not_found' => [new self(
            '/admin/delete/category/0',
            [],
            [
                'error' => 'The category with id 0 doesn\'t exist',
            ],
        )];
    }

    public static function dataTestDeleteCategoryNotFound(): \Generator
    {
        yield 'test_delete_category_not_found' => [new self(
            '/admin/delete/category/0',
            [],
            [
                'error' => 'The category with id 0 doesn\'t exist',
            ],
        )];
    }
}
