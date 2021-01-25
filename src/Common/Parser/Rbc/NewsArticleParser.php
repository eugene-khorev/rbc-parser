<?php


namespace App\Common\Parser\Rbc;


use App\Common\Parser\Html\CrawlerBasedParser;
use App\Common\Parser\Html\NewsArticleParserInterface;
use App\Common\Parser\Html\ParserException;
use Symfony\Component\DomCrawler\Crawler;

final class NewsArticleParser extends CrawlerBasedParser implements NewsArticleParserInterface
{
    private Crawler $article;
    private string $date;
    private string $title;
    private string $image;
    private string $body;

    /**
     * @inheritDoc
     */
    public function prepare(string $html): void
    {
        parent::prepare($html);

        try {
            $this->article = $this->crawler->filter('.article__content');

            $this->date =$this->getArticleDate();
            $this->title = $this->getArticleTile();
            $this->image = $this->getArticleImage();
            $this->body = $this->getArticleBody();
        } catch (\Exception $e) {
            throw new ParserException('Error preparing news article', previous: $e);
        }
    }

    public function getArticleTile(): string
    {
        return $this->title ??= $this->article->filter('.article__header__title h1')->text();
    }

    public function getArticleDate(): string
    {
        return $this->date ??= $this->article->filter('.article__header__date')->attr('content');
    }

    public function getArticleImage(): string
    {
        return $this->image ??= $this->article->filter('img.article__main-image__image')->attr('src');
    }

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
