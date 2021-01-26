<?php


namespace App\Common\Parser\Html;

/**
 * Interface NewsListParserInterface
 * Defines news list parser interface
 * @package App\Common\Parser\Html
 */
interface NewsListParserInterface extends ParserInterface
{
    /**
     * Return array of article URLs
     * @return array<string>
     */
    public function getArticleLinks(): array;
}
