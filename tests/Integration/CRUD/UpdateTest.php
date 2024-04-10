<?php

namespace Integration\CRUD;

use App\Infrastructure\Test\IntegrationTestCase;
use App\Tests\Common\CRUD\CrudTestDetails;
use App\Tests\Common\CRUD\Details\ArticleTestDetails;
use App\Tests\Common\CRUD\Details\CategoryTestDetails;
use App\Tests\Common\CRUD\Details\TagTestDetails;
use App\Tests\Common\Logged\LoggedTest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateTest extends IntegrationTestCase
{
    use LoggedTest;

    /**
     * @dataProvider dataProviderUpdateSuccess
     */
    public function testUpdateSuccess(CrudTestDetails $details): void
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', $details->getUrl());

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form')->form();

        foreach ($details->getDefaultValues() as $key => $value) {
            $this->assertSame($value, $form->get($key)->getValue());
        }

        foreach ($details->getValues() as $key => $value) {
            $form->get($key)->setValue($value);
        }

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('html', $details->getSuccessMessage());
    }

    public static function dataProviderUpdateSuccess(): \Generator
    {
        yield from ArticleTestDetails::dataTestUpdateArticleSuccess();
        yield from CategoryTestDetails::dataTestUpdateCategorySuccess();
        yield from TagTestDetails::dataTestUpdateTagSuccess();
    }

    /**
     * @dataProvider dataProviderCreateFailed
     */
    public function testUpdateFailed(CrudTestDetails $details): void
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', $details->getUrl());

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form')->form();

        foreach ($details->getDefaultValues() as $key => $value) {
            $this->assertSame($value, $form->get($key)->getValue());
        }

        foreach ($details->getValues() as $key => $value) {
            $form->get($key)->setValue($value);
        }

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSelectorTextContains('html', $details->getSuccessMessage());
    }

    public static function dataProviderCreateFailed(): \Generator
    {
        yield from ArticleTestDetails::dataTestUpdateArticleFailed();
        yield from CategoryTestDetails::dataTestUpdateCategoryFailed();
        yield from TagTestDetails::dataTestUpdateTagFailed();
    }

    /**
     * @dataProvider dataProviderNotFoundEntity
     */
    public function testUpdateEntityNotFound(CrudTestDetails $details): void
    {
        $client = $this->createClient();

        $client->catchExceptions(false);
        $this->expectException(NotFoundHttpException::class);

        $crawler = $client->request('GET', $details->getUrl());

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public static function dataProviderNotFoundEntity(): \Generator
    {
        yield from ArticleTestDetails::dataTestUpdateArticleNotFound();
        yield from CategoryTestDetails::dataTestUpdateCategoryNotFound();
        yield from TagTestDetails::dataTestUpdateTagNotFound();
    }
}
