<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ParseNewsCommand extends Command
{
    protected bool $requirePassword;
    protected HttpClientInterface $client;

    public function __construct(HttpClientInterface $client, bool $requirePassword = false)
    {
        $this->client = $client;
        $this->requirePassword = $requirePassword;

        parent::__construct('app:parse-news');
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
            ->addArgument(
                'password',
                $this->requirePassword ? InputArgument::REQUIRED : InputArgument::OPTIONAL,
                'User password',
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->client->request('GET', 'http://www.rbc.ru/');

        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
//        $output->writeln([
//            $statusCode,
//            $contentType,
//            $content,
//        ]);

        $crawler = new Crawler($content);
        $crawler
            ->filter('.js-news-feed-list > a.news-feed__item')
            ->each(function (Crawler $link, $i) use ($output) {
                $title = $link->filter('.news-feed__item__title');
                $linkHref = $link->attr('href');

                $response = $this->client->request('GET', $linkHref);
                $content = $response->getContent();
                $crawler = new Crawler($content);

                $article = $crawler->filter('.article__content');
                $date = $article->filter('.article__header__date');
                if ($date->count() > 0) {
                    $image = $article->filter('img.article__main-image__image');
                    $output->writeln([
                        $titleText = $title->text(),
                        $linkHref = $link->attr('href'),
                        $dateString = $date->attr('content'),
                        $imageUrl = $image->count() > 0 ? $image->attr('src') : null,
                    ]);
                    $text = $article->filter('.article__text');
                    $paragraphs = $text
                        ->filter('.article__text__overview, p')
                        ->extract(['_text']);
                    $output->writeln($paragraphs);
                    $output->writeln(['', '=====================================================', '']);
                }
            });

        return Command::SUCCESS;
    }
}
