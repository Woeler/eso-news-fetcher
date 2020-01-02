<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\PatchNotesArticle;

class LivePatchNotesFetcher extends RssFeedFetcher
{
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
        return 'live';
    }

    protected function getFeedUrl(): string
    {
        return 'https://forums.elderscrollsonline.com/en/categories/patch-notes/feed.rss';
    }
}
