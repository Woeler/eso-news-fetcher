<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Article;

interface ArticleInterface
{
    public function getTitle(): string;

    public function getLink(): string;

    public function getImage(): string;

    public function getDescription(): string;

    public function getTimestamp(): \DateTime;
}
