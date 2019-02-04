# Eso News Fetcher [![Build Status](https://travis-ci.org/Woeler/eso-news-fetcher.svg?branch=master)](https://travis-ci.org/Woeler/eso-news-fetcher)
A PHP library that fetches news about The Elder Scrolls Online in an OOP way.
## Installation
```sh
composer require woeler/eso-news-fetcher
```

## Usage
Getting official news
```php
$f = new \Woeler\EsoNewsFetcher\Fetcher\NewsFetcher();

foreach ($f->fetchAll(true) as $article) {
    echo $article->getTitle();
    echo $article->getImage();
    echo $article->getDescription();
}
```

Getting live patch notes
```php
$f = new \Woeler\EsoNewsFetcher\Fetcher\LivePatchNotesFetcher();

foreach ($f->fetchAll(true) as $article) {
    echo $article->getTitle();
    echo $article->getImage();
    echo $article->getDescription();
}
```

Getting pts patch notes
```php
$f = new \Woeler\EsoNewsFetcher\Fetcher\PtsPatchNotesFetcher();

foreach ($f->fetchAll(true) as $article) {
    echo $article->getTitle();
    echo $article->getImage();
    echo $article->getDescription();
}
```