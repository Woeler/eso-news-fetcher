<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Article;

class LuxuryFurnisherArticle extends AbstractArticle
{
    /**
     * @var array
     */
    protected $items = [];

    public function fetchOgMetaTags()
    {
        return;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return 'https://projects.woeler.tech/img/luxury-furnisher.jpg';
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }
}
