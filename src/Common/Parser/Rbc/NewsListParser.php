<?php


namespace App\Common\Parser\Rbc;


use App\Common\Parser\Html\CrawlerBasedParser;
use App\Common\Parser\Html\NewsListParserInterface;
use App\Common\Parser\Html\ParserException;
use Symfony\Component\DomCrawler\Crawler;

final class NewsListParser extends CrawlerBasedParser implements NewsListParserInterface
{

    private Crawler $links;

    /**
     * @inheritDoc
     */
    public function prepare(string $html): void
    {
        parent::prepare($html);

        try {
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
