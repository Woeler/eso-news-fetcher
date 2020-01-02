<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Exception\InvalidResponseException;

abstract class RedditFetcher implements FetcherInterface
{
    /**
     * @var string
     */
    protected $subreddit = 'elderscrollsonline';

    /**
     * @var array
     */
    protected $allowedUsers = ['The_Dwemer_Automaton'];

    protected function getFeedUrl(): string
    {
        return 'https://www.reddit.com/r/'.$this->subreddit.'/new.json';
    }

    protected function hasAllowedAuthor(array $post): bool
    {
        return \in_array($post['data']['author'], $this->allowedUsers, true);
    }

    /**
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
}
