<?php


namespace App\Common\Parser\Rbc;


use App\Common\Parser\Html\CrawlerBasedParser;
use App\Common\Parser\Html\NewsArticleParserInterface;
use App\Common\Parser\Html\ParserException;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class NewsArticleParser
 * Crawler based news article parser for https://www.rbc.ru
 * @package App\Common\Parser\Rbc
 */
final class NewsArticleParser extends CrawlerBasedParser implements NewsArticleParserInterface
{
    /**
     * @var Crawler Symfony Crawler component
     */
    private Crawler $article;

    /**
     * @var string Article date
     */
    private string $date;

    /**
     * @var string Article title
     */
    private string $title;

    /**
     * @var string Article image URL
     */
    private string $image;

    /**
     * @var string Article body
     */
    private string $body;

    /**
     * @inheritDoc
     */
    public function prepare(string $html): void
    {
        parent::prepare($html);

        try {
            // Find article content container
            $this->article = $this->crawler->filter('.article__content');

            // Get article data
            $this->date = $this->getArticleDate();
            $this->title = $this->getArticleTile();
            $this->image = $this->getArticleImage();
            $this->body = $this->getArticleBody();
        } catch (\Exception $e) {
            throw new ParserException('Error preparing news article', previous: $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function getArticleTile(): string
    {
        return $this->title ??= $this->article->filter('.article__header__title h1')->text();
    }

    /**
     * @inheritDoc
     */
    public function getArticleDate(): string
    {
        return $this->date ??= $this->article->filter('.article__header__date')->attr('content');
    }

    /**
     * @inheritDoc
     */
    public function getArticleImage(): string
    {
        return $this->image ??= $this->article->filter('img.article__main-image__image')->attr('src');
    }

    /**
     * @inheritDoc
     */
    public function getArticleBody(): string
    {
        return $this->body ??= implode('',
            $this->article
                ->filter('.article__text')
                ->filter('.article__text__overview, p')
                ->extract(['_text'])
        );
    }

}
