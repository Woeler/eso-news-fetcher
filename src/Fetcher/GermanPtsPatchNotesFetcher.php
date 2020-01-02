<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

class GermanPtsPatchNotesFetcher extends PtsPatchNotesFetcher
{
    /**
     * @var string
     */
    protected $checkString = 'PTS-Patchnotizen';

    public function getFeedUrl(): string
    {
        return 'https://forums.elderscrollsonline.com/de/categories/%C3%B6ffentlicher-testserver/feed.rss';
    }
}
