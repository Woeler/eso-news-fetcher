<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\EsoArticle;

class RedditFetcher extends AbstractFetcher
{
    public const TYPE_DAILY   = 'daily';
    public const TYPE_WEEKDAY = 'weekday';

    /**
     * @var string
     */
    protected $subreddit = 'elderscrollsonline';

    /**
     * @var array
     */
    protected $allowedUsers = ['The_Dwemer_Automaton'];
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
     * @var string
     */
    private $type;

    /**
     * RedditFetcher constructor.
     *
     * @param string $type
     */
    public function __construct(string $type = self::TYPE_DAILY)
    {
        parent::__construct();
        $this->type = $type;
    }

    /**
     * @return array
     */
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

    /**
     * @return string
     */
    protected function getFeedUrl(): string
    {
        return 'https://www.reddit.com/r/'.$this->subreddit.'/hot.json';
    }

    /**
     * @param array $post
     *
     * @return bool
     */
    private function hasAllowedAuthor(array $post): bool
    {
        return \in_array($post['data']['author'], $this->allowedUsers, true);
    }

    /**
     * @param string $title
     *
     * @return bool
     */
    private function shouldBeFetched(string $title): bool
    {
        if (self::TYPE_DAILY === $this->type) {
            return false !== strpos($title, '[Daily]');
        }

        return in_array($title, $this->reddit_titles, true);
    }
}
