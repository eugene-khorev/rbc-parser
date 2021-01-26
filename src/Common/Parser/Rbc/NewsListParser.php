<?php


namespace App\Common\Parser\Rbc;


use App\Common\Parser\Html\CrawlerBasedParser;
use App\Common\Parser\Html\NewsListParserInterface;
use App\Common\Parser\Html\ParserException;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class NewsListParser
 * Crawler based news list parser for https://www.rbc.ru
 * @package App\Common\Parser\Rbc
 */
final class NewsListParser extends CrawlerBasedParser implements NewsListParserInterface
{

    /**
     * @var Crawler Symfony Crawler component
     */
    private Crawler $links;

    /**
     * @inheritDoc
     */
    public function prepare(string $html): void
    {
        parent::prepare($html);

        try {
            // Find article links
            $this->links = $this->crawler->filter('.js-news-feed-list > a.news-feed__item');
        } catch (\RuntimeException $e) {
            throw new ParserException('Error preparing news list', previous: $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function getArticleLinks(): array
    {
        return $this->links->each(function (Crawler $link, $i) {
            return $link->attr('href');
        });
    }

}
