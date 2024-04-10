<?php

namespace Integration\CRUD;

use App\Infrastructure\Test\IntegrationTestCase;
use App\Tests\Common\CRUD\CrudTestDetails;
use App\Tests\Common\CRUD\Details\ArticleTestDetails;
use App\Tests\Common\CRUD\Details\CategoryTestDetails;
use App\Tests\Common\CRUD\Details\TagTestDetails;
use App\Tests\Common\Logged\LoggedTest;
use Symfony\Component\HttpFoundation\Response;

class DeleteTest extends IntegrationTestCase
{
    use LoggedTest;

    /**
     * @dataProvider dataProviderDeleteSuccess
     */
    public function testDeleteSuccessfully(CrudTestDetails $details): void
    {
        $client = $this->createClient();

        $client->request('GET', $details->getUrl());

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('html', $details->getSuccessMessage());
    }

    public static function dataProviderDeleteSuccess(): \Generator
    {
        yield from ArticleTestDetails::dataTestDeleteArticleSuccess();
        yield from CategoryTestDetails::dataTestDeleteCategorySuccess();
        yield from TagTestDetails::dataTestDeleteTagSuccess();
    }

    /**
     * @dataProvider dataProviderDeleteFailed
     */
    public function testDeleteFailed(CrudTestDetails $details): void
    {
        $client = $this->createClient();

        $client->request('GET', $details->getUrl());

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('html', $details->getErrorMessage());
    }

    public static function dataProviderDeleteFailed(): \Generator
    {
        yield from ArticleTestDetails::dataTestDeleteArticleFailed();
        yield from CategoryTestDetails::dataTestDeleteCategoryFailed();
        yield from TagTestDetails::dataTestDeleteTagFailed();
    }
}
