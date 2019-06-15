<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\GoldenVendorArticle;

class GoldenVendorFetcher extends VendorFetcher
{
    /**
     * @var string
     */
    protected $search = 'ESO GOLDEN VENDOR ITEMS';

    /**
     * @param bool $withOgTags
     *
     * @return array
     *
     * @throws \Woeler\EsoNewsFetcher\Exception\InvalidResponseException
     */
    public function fetchAll(bool $withOgTags = false): array
    {
        $articles = [];
        foreach ($this->makeRequest() as $item) {
            $title       = html_entity_decode($item['title']['rendered']);

            if (false === strpos(strtoupper($title), $this->search)) {
                continue;
            }

            $link        = $item['link'];
            $pubDate     = $this->timeToUtc($item['date']);
            $description = '';
            $items       = $this->buildItemsArray($item['content']['rendered']);

            foreach ($items as $vendorItem) {
                $description .= '* '.$vendorItem.PHP_EOL;
            }

            $description = str_replace('* >What is offered this week?The Golden vendor is a special vendor located in one of base camps for each faction in Cyrodiil that only appears on the weekend to sell monster sets that are obtained in the various group dungeons around Tamriel.', '', $description);

            $article = new GoldenVendorArticle($title, $link, $pubDate, '', $description);
            $article->setItems($items);
            $articles[] = $article;
        }

        return $articles;
    }

    /**
     * @return string
     */
    protected function getFeedUrl(): string
    {
        return 'http://benevolentbowd.ca/wp-json/wp/v2/posts';
    }
}
