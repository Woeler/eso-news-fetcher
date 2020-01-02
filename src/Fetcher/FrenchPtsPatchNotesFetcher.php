<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

class FrenchPtsPatchNotesFetcher extends PtsPatchNotesFetcher
{
    /**
     * @var string
     */
    protected $checkString = 'Notes de version PTS';

    public function getFeedUrl(): string
    {
        return 'https://forums.elderscrollsonline.com/fr/categories/pts-serveur-de-test-public/feed.rss';
    }
}
