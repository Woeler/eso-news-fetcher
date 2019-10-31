<?php

namespace Woeler\EsoNewsFetcher\Article;

class ServiceAnnouncementArticle extends AbstractArticle
{
    public function fetchOgMetaTags()
    {
        return;
    }

    public function getTitle(): string
    {
        return 'ESO Service Announcement';
    }

    public function getLink(): string
    {
        return 'https://help.elderscrollsonline.com/app/answers/detail/a_id/4320';
    }

    public function getImage(): string
    {
        return '';
    }
}
