<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

use Woeler\EsoNewsFetcher\Article\EsoArticle;

class NewsFetcher extends AbstractFetcher
{
    public const LANG_EN_US = 'en-us';
    public const LANG_EN_GB = 'en-gb';
    public const LANG_DE    = 'de';
    public const LANG_FR    = 'fr';
    public const LANG_RU    = 'ru';
    public const LANG_ES    = 'es';
    public const LANG_CN    = 'cn';
    public const LANG_JA    = 'ja';

    public function __construct(private string $lang = self::LANG_EN_US)
    {
        parent::__construct();
    }

    /**
     * @return array|EsoArticle[]
     */
    public function fetchAll(): array
    {
        if (self::LANG_JA === $this->lang) {
            return (new JapaneseNewsFetcher())->fetchAll();
        }

        $articles     = [];
        $articleArray = $this->getJsonFeedAsArray();

        foreach ($articleArray as $item) {
            $article = new EsoArticle(
                $item['content']['title']['main'],
                'https://www.elderscrollsonline.com/'.$this->lang.'/news/post/'.$item['metadata']['parent_id'],
                new \DateTime('@'.$item['metadata']['dates']['start_date']),
                $item['content']['images']['lead_image'],
                $item['content']['intro']['text']
                );

            $articles[] = $article;
        }

        return $articles;
    }

    protected function getFeedUrl(): string
    {
        return 'https://www.elderscrollsonline.com/'.$this->lang.'/news/post/list';
    }
}
