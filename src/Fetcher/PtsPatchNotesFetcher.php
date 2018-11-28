<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\PatchNotesArticle;

class PtsPatchNotesFetcher extends RssFeedFetcher
{
    /**
     * @param bool $withOgTags
     *
     * @return array
     *
     * @throws \Rugaard\MetaScraper\Exceptions\InvalidUrlException
     * @throws \Rugaard\MetaScraper\Exceptions\RequestFailedException
     */
    public function fetchAll(bool $withOgTags = false): array
    {
        $articleArray = $this->rssToArray($this->getFeedUrl());
        $articles     = [];

        foreach ($articleArray as $item) {
            if (\in_array($item['creator'], PatchNotesArticle::ALLOWED_AUTHORS, true)) {
                if (false === strpos($item['title'], 'PTS Patch Notes')) {
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

    /**
     * @return string
     */
    protected function getContext(): string
    {
        return 'pts';
    }

    /**
     * @return string
     */
    protected function getFeedUrl(): string
    {
        return 'https://forums.elderscrollsonline.com/en/categories/pts/feed.rss';
    }
}
