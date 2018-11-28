<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Article;

use Rugaard\MetaScraper\Scraper;

abstract class AbstractArticle implements ArticleInterface
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $image;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var \DateTime
     */
    protected $timestamp;

    /**
     * AbstractArticle constructor.
     *
     * @param string    $title
     * @param string    $link
     * @param string    $image
     * @param string    $description
     * @param \DateTime $timestamp
     */
    public function __construct(string $title, string $link, \DateTime $timestamp, string $image = '', string $description = '')
    {
        $this->title       = str_replace('&amp;', 'and', $title);
        $this->link        = $link;
        $this->image       = $image;
        $this->description = $description;
        $this->timestamp   = $timestamp;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    /**
     * @throws \Rugaard\MetaScraper\Exceptions\InvalidUrlException
     * @throws \Rugaard\MetaScraper\Exceptions\RequestFailedException
     */
    public function fetchOgMetaTags()
    {
        $scraper = new Scraper();
        $scraper->load($this->link);
        try {
            foreach ($scraper->openGraph() as $key => $meta) {
                if ('image' === $key) {
                    if (is_array($meta)) {
                        $this->image = $meta[0]->getUrl();
                    } else {
                        $this->image = $meta->getUrl();
                    }
                } elseif ('description' === $key) {
                    $this->description = $meta;
                }
            }
            if (empty($this->image)) {
                foreach ($scraper->twitter() as $key => $meta) {
                    if ('image' === $key) {
                        if (is_array($meta)) {
                            $this->image = $meta[0]->getUrl();
                        } else {
                            $this->image = $meta->getUrl();
                        }
                    } elseif ('description' === $key) {
                        $this->description = $meta;
                    }
                }
            }
        } catch (\Exception $e) {
        }
    }
}
