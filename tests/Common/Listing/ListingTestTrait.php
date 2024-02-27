<?php

namespace App\Tests\Common\Listing;

use Symfony\Component\DomCrawler\Crawler;

trait ListingTestTrait
{
    public function listingSuccessResponse(ListingTestDetails $details): Crawler
    {
        $client = self::createClient();

        $crawler = $client->request('GET', $details->getUrl());

        $this->assertResponseIsSuccessful();

        $this->assertSelectorCount($details->getCount(), $details->getElement());

        if ($details->getCount() > 0 && $details->hasAssert()) {
            $this->assertStringContainsString($details->getFistElementId(), $crawler->filter($details->getFistSelector())->attr($details->getAttrSelector()));
            $this->assertStringContainsString($details->getLastElementId(), $crawler->filter($details->getLastSelector())->attr($details->getAttrSelector()));
        }

        return $crawler;
    }

    /**
     * @dataProvider dataFailedProvider
     */
    public function testListingFailedResponse(ListingTestDetails $details): void
    {
        $client = self::createClient();

        $client->catchExceptions(false);
        $this->expectException($details->getExceptionClass());

        $client->request('GET', $details->getUrl());

        $this->assertResponseStatusCodeSame(404);
    }
}
