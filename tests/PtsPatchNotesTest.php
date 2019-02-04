<?php

class PtsPatchNotesTest extends \PHPUnit\Framework\TestCase
{
    public function testFetch()
    {
        $fetcher  = new \Woeler\EsoNewsFetcher\Fetcher\PtsPatchNotesFetcher();
        $articles = $fetcher->fetchAll(false);

        if (0 === count($articles)) {
            $this->assertIsArray($articles);

            return;
        }

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
        $fetcher  = new \Woeler\EsoNewsFetcher\Fetcher\GermanPtsPatchNotesFetcher();
        $articles = $fetcher->fetchAll(false);

        if (0 === count($articles)) {
            return;
        }

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
        $fetcher  = new \Woeler\EsoNewsFetcher\Fetcher\FrenchPtsPatchNotesFetcher();
        $articles = $fetcher->fetchAll(false);

        if (0 === count($articles)) {
            return;
        }

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
