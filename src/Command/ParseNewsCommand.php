<?php

namespace App\Command;

use App\Common\Parser\Rbc\NewsArticleParser;
use App\Common\Parser\Rbc\NewsListParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ParseNewsCommand extends Command
{
    protected bool $requirePassword;
    protected HttpClientInterface $client;
    protected NewsListParser $newsListParser;
    protected NewsArticleParser $newsArticleParser;

    public function __construct(HttpClientInterface $client, bool $requirePassword = false)
    {
        $this->client = $client;

        $this->newsListParser = new NewsListParser;
        $this->newsArticleParser = new NewsArticleParser;

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

//        $statusCode = $response->getStatusCode();
//        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();

        $this->newsListParser->prepare($content);
        $articleLinks = $this->newsListParser->getArticleLinks();
        foreach ($articleLinks as $articleLink) {
            try {
                $response = $this->client->request('GET', $articleLink);
                $content = $response->getContent();

                $this->newsArticleParser->prepare($content);
                $output->writeln([
                    $articleLink,
                    $this->newsArticleParser->getArticleDate(),
                    $this->newsArticleParser->getArticleTile(),
                    $this->newsArticleParser->getArticleImage(),
                    $this->newsArticleParser->getArticleBody(),
                    '',
                    '=====================================================',
                    '',
                ]);
            } catch (\Exception) {
                continue;
            }
        }

        return Command::SUCCESS;
    }
}
