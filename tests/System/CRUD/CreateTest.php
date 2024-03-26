<?php

namespace System\CRUD;

use App\Tests\Common\CRUD\CrudTestDetails;
use App\Tests\Common\CRUD\Details\ArticleTestDetails;
use App\Tests\Common\Logged\LoggedTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateTest extends WebTestCase
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
        $this->assertSelectorTextContains('html', $details->getVerifyCount());
    }

    public static function dataProviderCreateSuccess(): \Generator
    {
        yield from ArticleTestDetails::dataTestCreateArticleSuccess();
    }

    /**
     * @dataProvider dataProviderCreateFailed
     */
    public function testCreatFailed(CrudTestDetails $details): void
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
    }
}