<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Fetcher;

interface FetcherInterface
{
    public function fetchAll(bool $withOgTags = false): array;
}
