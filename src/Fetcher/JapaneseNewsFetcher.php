<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\EsoArticle;

class JapaneseNewsFetcher extends AbstractFetcher
{
    protected array $rssTags = ['title', 'link', 'pubDate', 'creator', 'description'];

    /**
     * @return array|EsoArticle[]
     */
    public function fetchAll(): array
    {
        $articleArray = $this->getRssFeedAsArray();
        $articles     = [];

        foreach ($articleArray as $item) {
            $article    = new EsoArticle($item['title'], $item['link'], $this->timeToUtc($item['pubDate']), '', $item['description']);
            $articles[] = $article;
        }

        return $articles;
    }

    /**
     * @return string
     */
    protected function getFeedUrl(): string
    {
        return 'https://eso.dmm.com/rss';
    }

    /**
     * @param string $pubDate
     *
     * @return \DateTime
     */
    protected function timeToUtc(string $pubDate): \DateTime
    {
        $dt = new \DateTime('@'.strtotime($pubDate));
        $dt->setTimezone(new \DateTimeZone('UTC'));

        return $dt;
    }
}
