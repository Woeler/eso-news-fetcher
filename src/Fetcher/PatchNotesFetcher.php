<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\EsoArticle;

class PatchNotesFetcher extends AbstractFetcher
{
    public const LANG_EN      = 'en';
    public const LANG_DE      = 'de';
    public const LANG_FR      = 'fr';
    public const CONTEXT_LIVE = 'live';
    public const CONTEXT_PTS  = 'pts';

    private const FEEDS = [
        self::LANG_EN => [
            self::CONTEXT_LIVE => 'https://forums.elderscrollsonline.com/en/categories/patch-notes/feed.rss',
            self::CONTEXT_PTS  => 'https://forums.elderscrollsonline.com/en/categories/pts/feed.rss',
        ],
        self::LANG_DE => [
            self::CONTEXT_LIVE => 'https://forums.elderscrollsonline.com/de/categories/patchnotizen/feed.rss',
            self::CONTEXT_PTS  => 'https://forums.elderscrollsonline.com/de/categories/%C3%B6ffentlicher-testserver/feed.rss',
        ],
        self::LANG_FR => [
            self::CONTEXT_LIVE => 'https://forums.elderscrollsonline.com/fr/categories/notes-de-version/feed.rss',
            self::CONTEXT_PTS  => 'https://forums.elderscrollsonline.com/fr/categories/pts-serveur-de-test-public/feed.rss',
        ],
    ];

    private const ALLOWED_AUTHORS = [
        'ZOS_GinaBruno',
        'ZOS_KaiSchober',
        'ZOS_JessicaFolsom',
        'ZOS_LouisEvrard',
    ];

    /**
     * @var string
     */
    private $lang;
    /**
     * @var string
     */
    private $context;

    public function __construct(
        string $lang = self::LANG_EN,
        string $context = self::CONTEXT_LIVE
    ) {
        parent::__construct();

        $this->lang    = $lang;
        $this->context = $context;
    }

    /**
     * @return array|EsoArticle[]
     */
    public function fetchAll(): array
    {
        $articleArray = $this->getRssFeedAsArray();
        $articles     = [];

        foreach ($articleArray as $item) {
            if (\in_array($item['creator'], self::ALLOWED_AUTHORS, true)) {
                if (!$this->shouldProcess($item['title'])) {
                    continue;
                }
                $article    = new EsoArticle($item['title'], $item['link'], $this->timeToUtc($item['pubDate']));
                $articles[] = $article;
            }
        }

        return $articles;
    }

    /**
     * @param string $title
     *
     * @return bool
     */
    protected function shouldProcess(string $title): bool
    {
        if (self::CONTEXT_PTS === $this->context) {
            if (self::LANG_EN === $this->lang) {
                return false !== strpos($title, 'PTS Patch Notes');
            }
            if (self::LANG_DE === $this->lang) {
                return false !== strpos($title, 'PTS-Patchnotizen');
            }
            if (self::LANG_FR === $this->lang) {
                return false !== strpos($title, 'Notes de version PTS');
            }
        }

        return true;
    }

    /**
     * @return string
     */
    protected function getFeedUrl(): string
    {
        return self::FEEDS[$this->lang][$this->context];
    }

    /**
     * @param string $pubDate
     *
     * @return \DateTime
     */
    protected function timeToUtc(string $pubDate): \DateTime
    {
        $dt = new \DateTime('@'.strtotime($pubDate));
        $dt->setTimezone(new \DateTimeZone('UTC'));

        return $dt;
    }
}
