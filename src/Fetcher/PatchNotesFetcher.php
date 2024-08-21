<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\EsoArticle;

class PatchNotesFetcher extends AbstractFetcher
{
    public const LANG_EN      = 'en';
    public const LANG_DE      = 'de';
    public const LANG_FR      = 'fr';
    public const LANG_RU      = 'ru';
    public const LANG_ES      = 'es';
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
        self::LANG_RU => [
            self::CONTEXT_LIVE => 'https://forums.elderscrollsonline.com/ru/categories/patch-notes-r/feed.rss',
            self::CONTEXT_PTS  => 'https://forums.elderscrollsonline.com/ru/categories/%E2%80%A2%09public-test-server-russian/feed.xml',
        ],
        self::LANG_ES => [
            self::CONTEXT_LIVE => 'https://forums.elderscrollsonline.com/es/categories/notas-de-parche-y-revisiones/feed.rss',
            self::CONTEXT_PTS  => 'https://forums.elderscrollsonline.com/es/categories/servidor-de-prueba-p%C3%BAblico/feed.rss',
        ],
    ];

    private const ALLOWED_AUTHORS = [
        'ZOS_GinaBruno',
        'ZOS_KaiSchober',
        'ZOS_JessicaFolsom',
        'ZOS_LouisEvrard',
        'ZOS_Valeriya',
        'ElenaMinervae',
        'ZOS_Kevin',
    ];

    public function __construct(
        private string $lang = self::LANG_EN,
        private string $context = self::CONTEXT_LIVE
    ) {
        parent::__construct();
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
                return false !== mb_stripos($title, 'PTS Patch Notes');
            }
            if (self::LANG_DE === $this->lang) {
                return false !== mb_stripos($title, 'PTS-Patchnotizen');
            }
            if (self::LANG_FR === $this->lang) {
                return false !== mb_stripos($title, 'Notes de version PTS');
            }
            if (self::LANG_RU === $this->lang) {
                return false !== mb_stripos($title, 'публичного тестового сервера') && false !== mb_stripos($title, 'Описание обновления');
            }
            if (self::LANG_ES === $this->lang) {
                return false !== mb_stripos($title, 'Notas del parche del servidor de pruebas');
            }

            return false;
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
