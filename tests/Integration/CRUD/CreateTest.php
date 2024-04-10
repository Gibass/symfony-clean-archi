<?php

namespace Integration\CRUD;

use App\Infrastructure\Test\IntegrationTestCase;
use App\Tests\Common\CRUD\CrudTestDetails;
use App\Tests\Common\CRUD\Details\ArticleTestDetails;
use App\Tests\Common\CRUD\Details\TagTestDetails;
use App\Tests\Common\Logged\LoggedTest;
use App\Tests\Common\CRUD\Details\CategoryTestDetails;
use Symfony\Component\HttpFoundation\Response;

class CreateTest extends IntegrationTestCase
{
    use LoggedTest;

    /**
     * @dataProvider dataProviderCreateSuccess
     */
    public function testCreateSuccess(CrudTestDetails $details): void
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', $details->getUrl());

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form')->form($details->getValues());

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('html', $details->getSuccessMessage());
    }

    public static function dataProviderCreateSuccess(): \Generator
    {
        yield from ArticleTestDetails::dataTestCreateArticleSuccess();
        yield from CategoryTestDetails::dataTestCreateCategorySuccess();
        yield from TagTestDetails::dataTestCreateTagSuccess();
    }

    /**
     * @dataProvider dataProviderCreateFailed
     */
    public function testCreateFailed(CrudTestDetails $details): void
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', $details->getUrl());

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form')->form($details->getValues());

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSelectorTextContains('html', $details->getSuccessMessage());
    }

    public static function dataProviderCreateFailed(): \Generator
    {
        yield from ArticleTestDetails::dataTestCreateArticleFailed();
        yield from CategoryTestDetails::dataTestCreateCategoryFailed();
        yield from TagTestDetails::dataTestCreateTagFailed();
    }
}
