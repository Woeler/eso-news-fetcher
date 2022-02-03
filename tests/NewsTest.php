<?php

use Woeler\EsoNewsFetcher\Article\EsoArticle;
use Woeler\EsoNewsFetcher\Fetcher\NewsFetcher;

class NewsTest extends \PHPUnit\Framework\TestCase
{
    public function testFetch()
    {
        $fetcher  = new NewsFetcher();
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

    public function testFetchGerman()
    {
        $fetcher  = new NewsFetcher(NewsFetcher::LANG_DE);
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

    public function testFetchFrench()
    {
        $fetcher  = new NewsFetcher(NewsFetcher::LANG_FR);
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

    public function testFetchEnGb()
    {
        $fetcher  = new NewsFetcher(NewsFetcher::LANG_EN_GB);
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

    public function testFetchRussian()
    {
        $fetcher  = new NewsFetcher(NewsFetcher::LANG_RU);
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

    public function testFetchSpanish()
    {
        $fetcher  = new NewsFetcher(NewsFetcher::LANG_ES);
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
}
