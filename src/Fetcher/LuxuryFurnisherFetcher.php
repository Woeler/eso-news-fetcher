<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\LuxuryFurnisherArticle;

class LuxuryFurnisherFetcher extends VendorFetcher
{
    /**
     * @param bool $withOgTags
     *
     * @return array
     */
    public function fetchAll(bool $withOgTags = false): array
    {
        $articles = [];
        foreach ($this->makeRequest() as $item) {
            $title       = html_entity_decode($item['title']['rendered']);
            $link        = $item['link'];
            $pubDate     = $this->timeToUtc($item['date']);
            $description = '';
            $items       = $this->buildItemsArray($item['content']['rendered']);

            foreach ($items as $vendorItem) {
                $description .= '* '.$vendorItem.PHP_EOL;
            }

            $article = new LuxuryFurnisherArticle($title, $link, $pubDate, '', $description);
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
        return 'http://benevolentbowd.ca/wp-json/wp/v2/posts?categories=321';
    }
}
