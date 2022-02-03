<?php

namespace Woeler\EsoNewsFetcher\Article;

use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;

class EsoArticle
{
    public function __construct(
        protected string $title,
        protected string $link,
        protected \DateTimeInterface $timestamp,
        protected string $image = '',
        protected string $description = ''
    ) {
        $this->title       = str_replace('&amp;', 'and', $title);
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

    public function getTimestamp(): \DateTimeInterface
    {
        return $this->timestamp;
    }

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
