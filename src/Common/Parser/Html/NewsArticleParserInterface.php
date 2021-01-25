<?php


namespace App\Common\Parser\Html;


interface NewsArticleParserInterface extends ParserInterface
{
    public function getArticleTile(): string;
    public function getArticleDate(): string;
    public function getArticleImage(): string;
    public function getArticleBody(): string;
}
