<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\EsoArticle;

class VendorFetcher extends AbstractFetcher
{
    public const TYPE_GOLDEN_VENDOR    = 'golden';
    public const TYPE_LUXURY_FURNISHER = 'luxury';
    /**
     * @var string
     */
    private $type;

    public function __construct(string $type = self::TYPE_GOLDEN_VENDOR)
    {
        parent::__construct();
        $this->type = $type;
    }

    /**
     * @return array|EsoArticle[]
     */
    public function fetchAll(): array
    {
        $articles = [];
        foreach ($this->getJsonFeedAsArray() as $item) {
            $title = html_entity_decode($item['title']['rendered']);

            if (false === strpos(strtoupper($title), $this->getSearch())) {
                continue;
            }

            $link        = $item['link'];
            $pubDate     = $this->timeToUtc($item['date']);
            $description = '';
            $items       = $this->buildItemsArray($item['content']['rendered']);
            if (self::TYPE_GOLDEN_VENDOR === $this->type) {
                $image = 'https://projects.woeler.tech/img/golden-vendor.jpg';
            } else {
                $image = 'https://projects.woeler.tech/img/luxury-furnisher.jpg';
            }

            foreach ($items as $vendorItem) {
                $description .= '* '.$vendorItem.PHP_EOL;
            }

            if (self::TYPE_GOLDEN_VENDOR === $this->type) {
                $description = str_replace('* >What is offered this week?The Golden vendor is a special vendor located in one of base camps for each faction in Cyrodiil that only appears on the weekend to sell monster sets that are obtained in the various group dungeons around Tamriel.', '', $description);
            }

            $article    = new EsoArticle($title, $link, $pubDate, $image, $description);
            $articles[] = $article;
        }

        return $articles;
    }

    /**
     * @param string $pubDate
     *
     * @return \DateTime
     */
    protected function timeToUtc(string $pubDate): \DateTime
    {
        $dt = new \DateTime('@'.strtotime($pubDate));
        $dt->setTimezone(new \DateTimeZone('UTC'));

        return $dt;
    }

    /**
     * @param string $content
     *
     * @return array
     */
    protected function buildItemsArray(string $content): array
    {
        $splitted = substr($content,
            strpos($content, '<ul>') + 4,
            strpos($content, '</ul>') - strpos($content, '<ul>') - 4);
        $exploded = explode('</li>', $splitted);

        foreach ($exploded as $key => $list_item) {
            if (empty($list_item) || strlen($list_item) < 3) {
                unset($exploded[$key]);
                continue;
            }
            $exploded[$key] = str_replace('<li>', '', $list_item);
            $exploded[$key] = str_replace(["\r", "\n"], '', html_entity_decode($exploded[$key]));
            $exploded[$key] = strip_tags($exploded[$key]);
        }

        return $exploded;
    }

    /**
     * @return string
     */
    protected function getFeedUrl(): string
    {
        return 'http://benevolentbowd.ca/wp-json/wp/v2/posts';
    }

    /**
     * @return string
     */
    private function getSearch(): string
    {
        return self::TYPE_GOLDEN_VENDOR === $this->type ? 'ESO GOLDEN VENDOR ITEMS' : 'ESO LUXURY FURNITURE VENDOR ITEMS';
    }
}
