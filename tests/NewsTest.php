<?php

class NewsTest extends \PHPUnit\Framework\TestCase
{
    public function testFetch()
    {
        $fetcher  = new \Woeler\EsoNewsFetcher\Fetcher\NewsFetcher();
        $articles = $fetcher->fetchAll(false);

        /** @var \Woeler\EsoNewsFetcher\Article\NewsArticle $article */
        $article = $articles[0];

        $this->assertTrue(count($articles) > 0);
        $this->assertNotNull($article->getTitle());
        $this->assertNotNull($article->getTimestamp());
        $this->assertNotNull($article->getImage());
        $this->assertNotNull($article->getDescription());
        $this->assertNotNull($article->getLink());
    }

    public function testFetchGerman()
    {
        $fetcher  = new \Woeler\EsoNewsFetcher\Fetcher\GermanNewsFetcher();
        $articles = $fetcher->fetchAll(false);

        /** @var \Woeler\EsoNewsFetcher\Article\NewsArticle $article */
        $article = $articles[0];
        $article->fetchOgMetaTags();

        $this->assertTrue(count($articles) > 0);
        $this->assertNotNull($article->getTitle());
        $this->assertNotNull($article->getTimestamp());
        $this->assertNotNull($article->getImage());
        $this->assertNotNull($article->getDescription());
        $this->assertNotNull($article->getLink());
    }

    public function testFetchFrench()
    {
        $fetcher  = new \Woeler\EsoNewsFetcher\Fetcher\FrenchNewsFetcher();
        $articles = $fetcher->fetchAll(false);

        /** @var \Woeler\EsoNewsFetcher\Article\NewsArticle $article */
        $article = $articles[0];
        $article->fetchOgMetaTags();

        $this->assertTrue(count($articles) > 0);
        $this->assertNotNull($article->getTitle());
        $this->assertNotNull($article->getTimestamp());
        $this->assertNotNull($article->getImage());
        $this->assertNotNull($article->getDescription());
        $this->assertNotNull($article->getLink());
    }

    public function testFetchEnGb()
    {
        $fetcher  = new \Woeler\EsoNewsFetcher\Fetcher\EnGbNewsFetcher();
        $articles = $fetcher->fetchAll(false);

        /** @var \Woeler\EsoNewsFetcher\Article\NewsArticle $article */
        $article = $articles[0];
        $article->fetchOgMetaTags();

        $this->assertTrue(count($articles) > 0);
        $this->assertNotNull($article->getTitle());
        $this->assertNotNull($article->getTimestamp());
        $this->assertNotNull($article->getImage());
        $this->assertNotNull($article->getDescription());
        $this->assertNotNull($article->getLink());
    }
}
