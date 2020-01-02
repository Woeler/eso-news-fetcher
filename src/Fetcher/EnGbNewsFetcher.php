<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

class EnGbNewsFetcher extends NewsFetcher
{
    public function getFeedUrl(): string
    {
        return 'http://files.elderscrollsonline.com/rss/en-gb/eso-rss.xml';
    }
}
