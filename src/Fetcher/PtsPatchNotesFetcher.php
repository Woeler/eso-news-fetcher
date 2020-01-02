<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\PatchNotesArticle;

class PtsPatchNotesFetcher extends RssFeedFetcher
{
    /**
     * @var string
     */
    protected $checkString = 'PTS Patch Notes';

    /**
     * @throws \Rugaard\MetaScraper\Exceptions\InvalidUrlException
     * @throws \Rugaard\MetaScraper\Exceptions\RequestFailedException
     */
    public function fetchAll(bool $withOgTags = false): array
    {
        $articleArray = $this->rssToArray($this->getFeedUrl());
        $articles     = [];

        foreach ($articleArray as $item) {
            if (\in_array($item['creator'], PatchNotesArticle::ALLOWED_AUTHORS, true)) {
                if (false === strpos($item['title'], $this->checkString)) {
                    continue;
                }

                $article = new PatchNotesArticle($item['title'], $item['link'], $this->timeToUtc($item['pubDate']));

                if ($withOgTags) {
                    $article->fetchOgMetaTags();
                }

                $articles[] = $article;
            }
        }

        return $articles;
    }

    protected function getContext(): string
    {
        return 'pts';
    }

    protected function getFeedUrl(): string
    {
        return 'https://forums.elderscrollsonline.com/en/categories/pts/feed.rss';
    }
}
