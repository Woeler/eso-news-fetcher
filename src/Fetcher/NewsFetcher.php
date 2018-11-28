<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\NewsArticle;

class NewsFetcher extends RssFeedFetcher
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
            $article = new NewsArticle($item['title'], $item['link'], $this->timeToUtc($item['pubDate']));

            if ($withOgTags) {
                $article->fetchOgMetaTags();
            }

            $articles[] = $article;
        }

        return $articles;
    }

    /**
     * @return string
     */
    protected function getFeedUrl(): string
    {
        return 'http://files.elderscrollsonline.com/rss/en-us/eso-rss.xml';
    }
}
