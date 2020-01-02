<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\RedditArticle;

class RedditDailyPostFetcher extends RedditFetcher
{
    /**
     * @var string
     */
    protected $identifierString = '[Daily]';

    /**
     * @throws \Exception
     */
    public function fetchAll(bool $withOgTags = false): array
    {
        $reddit   = $this->makeRequest();
        $articles = [];

        foreach ($reddit['data']['children'] as $post) {
            if (!$this->hasAllowedAuthor($post)) {
                continue;
            }
            if (false === strpos($post['data']['title'], $this->identifierString)) {
                continue;
            }

            $dt = new \DateTime('@'.$post['data']['created_utc'], new \DateTimeZone('UTC'));

            $article    = new RedditArticle($post['data']['title'], $post['data']['url'], $dt);
            $articles[] = $article;
        }

        return $articles;
    }
}
