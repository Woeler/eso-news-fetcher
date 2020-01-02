<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

class FrenchNewsFetcher extends NewsFetcher
{
    public function getFeedUrl(): string
    {
        return 'http://files.elderscrollsonline.com/rss/fr/eso-rss.xml';
    }
}
