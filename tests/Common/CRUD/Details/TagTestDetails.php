<?php

namespace App\Tests\Common\CRUD\Details;

use App\Infrastructure\Doctrine\DataFixtures\TaxonomyTestFixtures;
use App\Tests\Common\CRUD\CrudTestDetails;

class TagTestDetails extends CrudTestDetails
{
    public static function dataTestCreateTagSuccess(): \Generator
    {
        yield 'test_create_tag_success' => [new self(
            '/admin/create/tag',
            ['tag[title]' => 'Custom Tag'],
            [
                'success' => 'The tag have been created successfully',
                'verifyCount' => '1 - 4 sur ' . (TaxonomyTestFixtures::TAG_NB_TOTAL + 1),
            ],
        )];
    }

    public static function dataTestCreateTagFailed(): \Generator
    {
        yield 'test_create_tag_empty_title' => [new self(
            '/admin/create/tag',
            ['tag[title]' => ''],
            ['error' => 'Value "" is blank, but was expected to contain a value.'],
        )];

        yield 'test_create_tag_long_title' => [new self(
            '/admin/create/tag',
            ['tag[title]' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, orci non maximus condimentum, magna ligula porta tellus, ac hendrerit lorem elit vitae urna. Cras eget tempus lectus. Nam sed dapibus leo. Aenean iaculis purus dui, at lobortis nunc.'],
            ['error' => 'Value "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, orci non maximus condim..." is too long, it should have no more than 255 characters, but has 256 characters.'],
        )];
    }

    public static function dataTestUpdateTagSuccess(): \Generator
    {
        yield 'test_update_tag_success' => [new self(
            '/admin/edit/tag/1',
            ['tag[title]' => 'Custom Title updated with 25 char min'],
            [
                'success' => 'The tag have been updated successfully',
                'defaultValues' => [
                    'tag[title]' => 'Empty',
                ],
                'verifyElement' => 'Custom Title updated with 25 char min',
            ],
        )];
    }

    public static function dataTestUpdateTagFailed(): \Generator
    {
        yield 'test_update_tag_empty_title' => [new self(
            '/admin/edit/tag/1',
            ['tag[title]' => ''],
            ['error' => 'Value "" is blank, but was expected to contain a value.'],
        )];

        yield 'test_update_tag_long_title' => [new self(
            '/admin/edit/tag/1',
            ['tag[title]' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, orci non maximus condimentum, magna ligula porta tellus, ac hendrerit lorem elit vitae urna. Cras eget tempus lectus. Nam sed dapibus leo. Aenean iaculis purus dui, at lobortis nunc.'],
            ['error' => 'Value "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, orci non maximus condim..." is too long, it should have no more than 255 characters, but has 256 characters.'],
        )];
    }

    public static function dataTestUpdateTagNotFound(): \Generator
    {
        yield 'test_update_tag_not_found' => [new self(
            '/admin/edit/tag/0',
        )];
    }

    public static function dataTestDeleteTagSuccess(): \Generator
    {
        yield 'test_delete_tag_success' => [new self(
            '/admin/delete/tag/1',
            [],
            [
                'success' => 'The tag have been deleted successfully',
                'verifyCount' => '1 - 2 sur ' . (TaxonomyTestFixtures::TAG_NB_TOTAL - 1),
            ],
        )];
    }

    public static function dataTestDeleteTagFailed(): \Generator
    {
        yield 'test_delete_tag_failed' => [new self(
            '/admin/delete/tag/10',
            [],
            [
                'error' => 'An error was occurred during deleting tag',
            ],
        )];

        yield 'test_delete_tag_not_found' => [new self(
            '/admin/delete/tag/0',
            [],
            [
                'error' => 'The tag with id 0 doesn\'t exist',
            ],
        )];
    }

    public static function dataTestDeleteTagNotFound(): \Generator
    {
        yield 'test_delete_tag_not_found' => [new self(
            '/admin/delete/tag/0',
            [],
            [
                'error' => 'The tag with id 0 doesn\'t exist',
            ],
        )];
    }
}
