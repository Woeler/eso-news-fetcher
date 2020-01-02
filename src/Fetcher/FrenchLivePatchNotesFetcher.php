<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

class FrenchLivePatchNotesFetcher extends LivePatchNotesFetcher
{
    public function getFeedUrl(): string
    {
        return 'https://forums.elderscrollsonline.com/fr/categories/notes-de-version/feed.rss';
    }
}
