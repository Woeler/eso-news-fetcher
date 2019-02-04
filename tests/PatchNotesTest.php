<?php

class PatchNotesTest extends \PHPUnit\Framework\TestCase
{
    public function testFetch()
    {
        $fetcher  = new \Woeler\EsoNewsFetcher\Fetcher\LivePatchNotesFetcher();
        $articles = $fetcher->fetchAll(false);

        /** @var \Woeler\EsoNewsFetcher\Article\PatchNotesArticle $article */
        $article = $articles[0];
        $article->fetchOgMetaTags();

        $this->assertTrue(count($articles) > 0);
        $this->assertNotNull($article->getTitle());
        $this->assertNotNull($article->getTimestamp());
        $this->assertNotNull($article->getImage());
        $this->assertNotNull($article->getDescription());
        $this->assertNotNull($article->getLink());
    }

    public function testFetchGerman()
    {
        $fetcher  = new \Woeler\EsoNewsFetcher\Fetcher\GermanLivePatchNotesFetcher();
        $articles = $fetcher->fetchAll(false);

        /** @var \Woeler\EsoNewsFetcher\Article\PatchNotesArticle $article */
        $article = $articles[0];
        $article->fetchOgMetaTags();

        $this->assertTrue(count($articles) > 0);
        $this->assertNotNull($article->getTitle());
        $this->assertNotNull($article->getTimestamp());
        $this->assertNotNull($article->getDescription());
        $this->assertNotNull($article->getLink());
    }

    public function testFetchFrench()
    {
        $fetcher  = new \Woeler\EsoNewsFetcher\Fetcher\FrenchLivePatchNotesFetcher();
        $articles = $fetcher->fetchAll(false);

        /** @var \Woeler\EsoNewsFetcher\Article\PatchNotesArticle $article */
        $article = $articles[0];
        $article->fetchOgMetaTags();

        $this->assertTrue(count($articles) > 0);
        $this->assertNotNull($article->getTitle());
        $this->assertNotNull($article->getTimestamp());
        $this->assertNotNull($article->getDescription());
        $this->assertNotNull($article->getLink());
    }
}
