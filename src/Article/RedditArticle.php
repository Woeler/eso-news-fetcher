<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Article;

class RedditArticle extends AbstractArticle
{
    public function fetchOgMetaTags()
    {
        return;
    }

    public function getImage(): string
    {
        return 'https://b.thumbs.redditmedia.com/ibUroRDpWpTUomoibvA3NlAgsJW0SWHpG0PaN00XOFk.png';
    }
}
