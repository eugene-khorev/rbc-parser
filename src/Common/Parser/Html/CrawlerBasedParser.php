<?php


namespace App\Common\Parser\Html;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class CrawlerBasedParser
 * HTML parser based on Symfony Crawler component
 * @package App\Common\Parser\Html
 */
class CrawlerBasedParser implements ParserInterface
{
    /**
     * @var Crawler Symfony Crawler component
     */
    protected Crawler $crawler;

    /**
     * CrawlerBasedParser constructor.
     */
    public function __construct()
    {
        $this->crawler = new Crawler;
    }

    /**
     * @inheritDoc
     */
    public function prepare(string $html): void
    {
        $this->crawler->clear();
        $this->crawler->addHtmlContent($html);
    }
}
