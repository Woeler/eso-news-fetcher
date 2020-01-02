<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Exception\InvalidResponseException;

abstract class VendorFetcher implements FetcherInterface
{
    /**
     * @param string $url
     *
     * @throws InvalidResponseException
     */
    protected function makeRequest(): array
    {
        $content = json_decode(file_get_contents($this->getFeedUrl()), true);

        if (empty($content)) {
            throw new InvalidResponseException();
        }

        return $content;
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

    abstract protected function getFeedUrl(): string;
}
