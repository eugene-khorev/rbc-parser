<?php


namespace App\Common\Parser\Html;

/**
 * Interface NewsArticleParserInterface
 * Defines news article parser interface
 * @package App\Common\Parser\Html
 */
interface NewsArticleParserInterface extends ParserInterface
{
    /**
     * Return article title
     * @return string Article title
     */
    public function getArticleTile(): string;

    /**
     * Return article date
     * @return string Article date
     */
    public function getArticleDate(): string;

    /**
     * Return article image URL (if any)
     * @return string Article image URL
     */
    public function getArticleImage(): string;

    /**
     * Return article body
     * @return string Article body
     */
    public function getArticleBody(): string;
}
