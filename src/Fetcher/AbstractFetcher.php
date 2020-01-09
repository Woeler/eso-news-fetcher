<?php

namespace Woeler\EsoNewsFetcher\Fetcher;

use DOMDocument;
use GuzzleHttp\Client;

abstract class AbstractFetcher
{
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var array
     */
    protected $rssTags = ['title', 'link', 'pubDate', 'creator'];

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @return array
     */
    protected function getJsonFeedAsArray(): array
    {
        $data = $this->client->request(
            'get',
            $this->getFeedUrl(),
            [
                'allow_redirects' => [
                    'max'             => 99,
                    'strict'          => true,
                    'referer'         => true,
                    'protocols'       => ['https', 'http'],
                    'track_redirects' => true,
                ],
                'headers' => ['Accept' => 'application/json', 'User-agent' => 'Eso-News-Fetcher'],
            ]
        );

        return json_decode((string) $data->getBody(), true);
    }

    /**
     * @return array
     */
    protected function getRssFeedAsArray(): array
    {
        $doc          = new DOMdocument();
        $doc->recover = true;
        $data         = $this->client->request(
            'get',
            $this->getFeedUrl(),
            [
                'allow_redirects' => [
                    'max'             => 99,
                    'strict'          => true,
                    'referer'         => true,
                    'protocols'       => ['https', 'http'],
                    'track_redirects' => true,
                ],
            ]
        );
        $doc->loadXML((string) $data->getBody());
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

    abstract protected function getFeedUrl(): string;
}
