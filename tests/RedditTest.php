<?php

use PHPUnit\Framework\TestCase;
use Woeler\EsoNewsFetcher\Article\EsoArticle;
use Woeler\EsoNewsFetcher\Fetcher\RedditFetcher;

class RedditTest extends TestCase
{
    public function testFetchDaily()
    {
        $fetcher  = new RedditFetcher(RedditFetcher::TYPE_DAILY);
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

    public function testFetchWeekday()
    {
        $fetcher  = new RedditFetcher(RedditFetcher::TYPE_WEEKDAY);
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
