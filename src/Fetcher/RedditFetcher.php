<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\EsoArticle;

class RedditFetcher extends AbstractFetcher
{
    public const TYPE_DAILY   = 'daily';
    public const TYPE_WEEKDAY = 'weekday';

    protected string $subreddit    = 'elderscrollsonline';
    protected array $allowedUsers  = ['The_Dwemer_Automaton'];
    protected array $reddit_titles = [
        'Trendy Tuesday - Post your ESO outfits and homes!',
        'Workshop Wednesday - Give Crafting Tips, Offer Services, Help Your Fellow Crafters!',
        'Theorycraft Thursday - Discuss Builds, Skills, Strategies, and More!',
        'Guild Fair Friday - Advertise your guild, Find a guild!',
        'Mages Guild Monday - Share Your ESO Knowledge, Ask Questions, Get Info If You\'re New!',
    ];

    public function __construct(private string $type = self::TYPE_DAILY)
    {
        parent::__construct();
    }

    public function fetchAll(): array
    {
        $reddit   = $this->getJsonFeedAsArray();
        $articles = [];

        foreach ($reddit['data']['children'] as $post) {
            if (!$this->hasAllowedAuthor($post)) {
                continue;
            }
            if (!$this->shouldBeFetched($post['data']['title'])) {
                continue;
            }

            $dt = new \DateTime('@'.$post['data']['created_utc'], new \DateTimeZone('UTC'));

            $article    = new EsoArticle($post['data']['title'], $post['data']['url'], $dt, 'https://b.thumbs.redditmedia.com/ibUroRDpWpTUomoibvA3NlAgsJW0SWHpG0PaN00XOFk.png');
            $articles[] = $article;
        }

        return $articles;
    }

    protected function getFeedUrl(): string
    {
        return 'https://www.reddit.com/r/'.$this->subreddit.'/hot.json';
    }

    private function hasAllowedAuthor(array $post): bool
    {
        return \in_array($post['data']['author'], $this->allowedUsers, true);
    }

    private function shouldBeFetched(string $title): bool
    {
        if (self::TYPE_DAILY === $this->type) {
            return str_contains($title, '[Daily]');
        }

        return in_array($title, $this->reddit_titles, true);
    }
}
