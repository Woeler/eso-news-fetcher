<?php

use Woeler\EsoNewsFetcher\Article\EsoArticle;
use Woeler\EsoNewsFetcher\Fetcher\PatchNotesFetcher;

class PtsPatchNotesTest extends \PHPUnit\Framework\TestCase
{
    public function testFetch()
    {
        $fetcher  = new PatchNotesFetcher(PatchNotesFetcher::LANG_EN, PatchNotesFetcher::CONTEXT_PTS);
        $articles = $fetcher->fetchAll();

        if (0 === count($articles)) {
            $this->assertIsArray($articles);

            return;
        }

        /** @var EsoArticle $article */
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
        $fetcher  = new PatchNotesFetcher(PatchNotesFetcher::LANG_DE, PatchNotesFetcher::CONTEXT_PTS);
        $articles = $fetcher->fetchAll();

        if (0 === count($articles)) {
            return;
        }

        /** @var EsoArticle $article */
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
        $fetcher  = new PatchNotesFetcher(PatchNotesFetcher::LANG_FR, PatchNotesFetcher::CONTEXT_PTS);
        $articles = $fetcher->fetchAll();

        if (0 === count($articles)) {
            return;
        }

        /** @var EsoArticle $article */
        $article = $articles[0];
        $article->fetchOgMetaTags();

        $this->assertTrue(count($articles) > 0);
        $this->assertNotNull($article->getTitle());
        $this->assertNotNull($article->getTimestamp());
        $this->assertNotNull($article->getDescription());
        $this->assertNotNull($article->getLink());
    }
}
