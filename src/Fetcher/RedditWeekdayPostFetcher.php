<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\RedditArticle;

class RedditWeekdayPostFetcher extends RedditFetcher
{
    /**
     * @var array
     */
    protected $reddit_titles = [
        'Trendy Tuesday - Post your ESO outfits and homes!',
        'Workshop Wednesday - Give Crafting Tips, Offer Services, Help Your Fellow Crafters!',
        'Theorycraft Thursday - Discuss Builds, Skills, Strategies, and More!',
        'Guild Fair Friday - Advertise your guild, Find a guild!',
        'Mages Guild Monday - Share Your ESO Knowledge, Ask Questions, Get Info If You\'re New!',
    ];

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
            if (!\in_array($post['data']['title'], $this->reddit_titles, true)) {
                continue;
            }

            $dt = new \DateTime('@'.$post['data']['created_utc'], new \DateTimeZone('UTC'));

            $article    = new RedditArticle($post['data']['title'], $post['data']['url'], $dt);
            $articles[] = $article;
        }

        return $articles;
    }
}
