<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

class GermanLivePatchNotesFetcher extends LivePatchNotesFetcher
{
    /**
     * @return string
     */
    public function getFeedUrl(): string
    {
        return 'https://forums.elderscrollsonline.com/de/categories/patchnotizen/feed.rss';
    }
}
