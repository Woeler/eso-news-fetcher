<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

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

    /**
     * @return string
     */
    protected function getFeedUrl(): string
    {
        return 'https://www.reddit.com/r/'.$this->subreddit.'/new.json';
    }

    /**
     * @param array $post
     *
     * @return bool
     */
    protected function hasAllowedAuthor(array $post): bool
    {
        return \in_array($post['data']['author'], $this->allowedUsers, true);
    }

    /**
     * @return array
     */
    protected function makeRequest(): array
    {
        return json_decode(file_get_contents($this->getFeedUrl()), true) ?? [];
    }
}
