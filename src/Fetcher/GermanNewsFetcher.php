<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

class GermanNewsFetcher extends NewsFetcher
{
    public function getFeedUrl(): string
    {
        return 'http://files.elderscrollsonline.com/rss/de/eso-rss.xml';
    }
}
