<?php


namespace App\Common\Parser\Html;

use Symfony\Component\DomCrawler\Crawler;

class CrawlerBasedParser implements ParserInterface
{
    protected Crawler $crawler;

    public function __construct()
    {
        $this->crawler = new Crawler;
    }

    public function prepare(string $html): void
    {
        $this->crawler->clear();
        $this->crawler->addHtmlContent($html);
    }
}
