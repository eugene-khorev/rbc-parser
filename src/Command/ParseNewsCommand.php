<?php

namespace App\Command;

use App\Common\Parser\HttpDataProvider;
use App\Common\Parser\Rbc\NewsArticleParser;
use App\Common\Parser\Rbc\NewsListParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class ParseNewsCommand extends Command
{
    protected bool $requirePassword;
    protected HttpDataProvider $httpDataProvider;
    protected NewsListParser $newsListParser;
    protected NewsArticleParser $newsArticleParser;

    public function __construct(HttpDataProvider $httpDataProvider, bool $requirePassword = false)
    {
        $this->httpDataProvider = $httpDataProvider;

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

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws ExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $content = $this->httpDataProvider->getData('http://www.rbc.ru/');

        $this->newsListParser->prepare($content);
        $articleLinks = $this->newsListParser->getArticleLinks();
        foreach ($articleLinks as $articleLink) {
            try {
                $content = $this->httpDataProvider->getData($articleLink);

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
            } catch (\Throwable) {
                continue;
            }
        }

        return Command::SUCCESS;
    }
}
