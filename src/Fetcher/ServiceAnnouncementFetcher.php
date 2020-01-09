<?php

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\EsoArticle;

class ServiceAnnouncementFetcher extends AbstractFetcher
{
    /**
     * @return array|EsoArticle[]
     */
    public function fetchAll(): array
    {
        $data   = file_get_contents($this->getFeedUrl());
        $data   = explode('<!-- ENTER ESO SERVICE ALERTS BELOW THIS LINE -->', $data)[1];
        $data   = explode('<div', $data)[0];
        $data   =  explode('<hr />', $data);
        $return = [];
        foreach ($data as $announcement) {
            $split = explode('</p>', $announcement);
            if (empty($split[0]) || empty($split[1]) || false === strpos($split[0], 'UTC')) {
                continue;
            }
            $return[] = new EsoArticle(
                'ESO Service Announcement',
                'https://help.elderscrollsonline.com/app/answers/detail/a_id/4320',
                $this->parseTime($split[0]),
                '',
                trim(strip_tags($split[1]))
            );
        }

        return $return;
    }

    protected function getFeedUrl(): string
    {
        return 'https://help.elderscrollsonline.com/app/answers/detail/a_id/4320';
    }

    private function parseTime(string $timeString): \DateTime
    {
        $timeString = explode('(', strip_tags($timeString))[0];
        $timeString = str_replace('&nbsp;', ' ', $timeString);
        $split      = explode('-', $timeString);
        $date       = trim($split[0]);
        $time       = trim(explode(' ', trim($split[1]))[0]);
        $date       = str_replace('.', '-', $date);

        return new \DateTime(trim($date.' '.$time), new \DateTimeZone('UTC'));
    }
}
