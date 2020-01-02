<?php

declare(strict_types=1);

namespace Woeler\EsoNewsFetcher\Article;

class PatchNotesArticle extends AbstractArticle
{
    const ALLOWED_AUTHORS = [
        'ZOS_GinaBruno',
        'ZOS_KaiSchober',
        'ZOS_JessicaFolsom',
        'ZOS_LouisEvrard',
    ];

    /**
     * @var string
     */
    protected $author;

    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function isFormAllowedAuthor(): bool
    {
        return \in_array($this->author, self::ALLOWED_AUTHORS, true);
    }
}
