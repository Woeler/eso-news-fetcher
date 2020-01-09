<?php

namespace Woeler\EsoNewsFetcher\Article;

use DateTime;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;

class EsoArticle
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
     * @var DateTime
     */
    protected $timestamp;

    /**
     * AbstractArticle constructor.
     *
     * @param string   $title
     * @param string   $link
     * @param DateTime $timestamp
     * @param string   $image
     * @param string   $description
     */
    public function __construct(string $title, string $link, DateTime $timestamp, string $image = '', string $description = '')
    {
        $this->title       = str_replace('&amp;', 'and', $title);
        $this->link        = $link;
        $this->image       = $image;
        $this->description = $description;
        $this->timestamp   = $timestamp;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTimestamp(): DateTime
    {
        return $this->timestamp;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchOgMetaTags(): void
    {
        $client  = new Client(['base_uri' => $this->link]);
        $content = $client->request('GET');
        $body    =  (string) $content->getBody();
        libxml_use_internal_errors(true);
        $doc = new DomDocument();
        $doc->loadHTML($body);
        $xpath = new DOMXPath($doc);
        $query = '//*/meta[starts-with(@property, \'og:\')]';
        $metas = $xpath->query($query);
        foreach ($metas as $meta) {
            if (empty($this->image) && 'og:image' === $meta->getAttribute('property')) {
                $this->image = $meta->getAttribute('content');
            }
            if (empty($this->description) && 'og:description' === $meta->getAttribute('property')) {
                $this->description = str_replace('(Image) ', '', $meta->getAttribute('content'));
            }
            if (!empty($this->image) && !empty($this->description)) {
                break;
            }
        }
    }
}
