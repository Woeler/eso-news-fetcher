<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

class GermanNewsFetcher extends NewsFetcher
{
    /**
     * @return string
     */
    public function getFeedUrl(): string
    {
        return 'http://files.elderscrollsonline.com/rss/de/eso-rss.xml';
    }
}
