<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Article;

class GoldenVendorArticle extends AbstractArticle
{
    /**
     * @var array
     */
    protected $items = [];

    public function fetchOgMetaTags()
    {
        return;
    }

    public function getImage(): string
    {
        return 'https://projects.woeler.tech/img/golden-vendor.jpg';
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items)
    {
        $this->items = $items;
    }
}
