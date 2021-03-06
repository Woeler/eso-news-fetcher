<?php

use Woeler\EsoNewsFetcher\Article\EsoArticle;
use Woeler\EsoNewsFetcher\Fetcher\VendorFetcher;

class VendorTest extends \PHPUnit\Framework\TestCase
{
    public function testFetchGoldenVendor()
    {
        $fetcher  = new VendorFetcher(VendorFetcher::TYPE_GOLDEN_VENDOR);
        $articles = $fetcher->fetchAll();

        /** @var EsoArticle $article */
        $article = $articles[0];

        $this->assertTrue(count($articles) > 0);
        $this->assertNotNull($article->getTitle());
        $this->assertNotNull($article->getTimestamp());
        $this->assertNotNull($article->getImage());
        $this->assertNotNull($article->getDescription());
        $this->assertNotNull($article->getLink());
    }

    public function testFetchLuxuryFurnisher()
    {
        $fetcher  = new VendorFetcher(VendorFetcher::TYPE_LUXURY_FURNISHER);
        $articles = $fetcher->fetchAll();

        /** @var EsoArticle $article */
        $article = $articles[0];

        $this->assertTrue(count($articles) > 0);
        $this->assertNotNull($article->getTitle());
        $this->assertNotNull($article->getTimestamp());
        $this->assertNotNull($article->getDescription());
        $this->assertNotNull($article->getLink());
    }
}
