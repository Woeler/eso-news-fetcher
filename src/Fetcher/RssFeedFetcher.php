<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use DOMDocument;

abstract class RssFeedFetcher implements FetcherInterface
{
    /**
     * @var array
     */
    protected $rssTags = ['title', 'link', 'pubDate', 'creator'];

    abstract protected function getFeedUrl(): string;

    protected function rssToArray(string $feed): array
    {
        $doc          = new DOMdocument();
        $doc->recover = true;
        $file         = str_replace('&nbsp;', '', file_get_contents($feed));
        $doc->loadXML($file);
        $rss_array = [];

        foreach ($doc->getElementsByTagName('item') as $node) {
            $items     = [];

            foreach ($this->rssTags as $value) {
                $items[$value] = $node->getElementsByTagName($value)->item(0)->nodeValue;
            }

            $rss_array[] = $items;
        }

        return $rss_array;
    }

    /**
     * @throws \Exception
     */
    protected function timeToUtc(string $pubDate): \DateTime
    {
        $dt = new \DateTime('@'.strtotime($pubDate));
        $dt->setTimezone(new \DateTimeZone('UTC'));

        return $dt;
    }
}
