<?php


namespace App\Common\Parser\Html;


interface NewsListParserInterface extends ParserInterface
{
    /**
     * @return array<string>
     */
    public function getArticleLinks(): array;
}
