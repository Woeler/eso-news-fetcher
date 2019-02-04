<?php

class VendorTest extends \PHPUnit\Framework\TestCase
{
    public function testFetchGoldenVendor()
    {
        $fetcher  = new \Woeler\EsoNewsFetcher\Fetcher\GoldenVendorFetcher();
        $articles = $fetcher->fetchAll(false);

        /** @var \Woeler\EsoNewsFetcher\Article\GoldenVendorArticle $article */
        $article = $articles[0];
        $article->fetchOgMetaTags();

        $this->assertTrue(count($articles) > 0);
        $this->assertNotNull($article->getTitle());
        $this->assertNotNull($article->getTimestamp());
        $this->assertNotNull($article->getImage());
        $this->assertNotNull($article->getDescription());
        $this->assertNotNull($article->getLink());
    }

    public function testFetchLuxuryFurnisher()
    {
        $fetcher  = new \Woeler\EsoNewsFetcher\Fetcher\LuxuryFurnisherFetcher();
        $articles = $fetcher->fetchAll(false);

        /** @var \Woeler\EsoNewsFetcher\Article\LuxuryFurnisherArticle $article */
        $article = $articles[0];
        $article->fetchOgMetaTags();

        $this->assertTrue(count($articles) > 0);
        $this->assertNotNull($article->getTitle());
        $this->assertNotNull($article->getTimestamp());
        $this->assertNotNull($article->getDescription());
        $this->assertNotNull($article->getLink());
    }
}
