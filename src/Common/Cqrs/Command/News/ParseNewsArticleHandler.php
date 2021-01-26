<?php


namespace App\Common\Cqrs\Command\News;


use App\Common\Cqrs\Command\CommandHandlerInterface;
use App\Common\Parser\DataProviderInterface;
use App\Common\Parser\Html\NewsArticleParserInterface;
use App\Common\Parser\Html\NewsListParserInterface;
use Psr\Log\LoggerInterface;

final class ParseNewsArticleHandler implements CommandHandlerInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private DataProviderInterface $dataProvider,
        private NewsListParserInterface $newsListParser,
        private NewsArticleParserInterface $newsArticleParser
    ) {}

    public function __invoke(ParseNewsArticleCommand $command): void
    {
        $articleLink = $command->getArticleLink();
        try {
            $content = $this->dataProvider->getData($articleLink);

            $this->newsArticleParser->prepare($content);
            $this->logger->info('News article parsed', [
                $articleLink,
                $this->newsArticleParser->getArticleDate(),
                $this->newsArticleParser->getArticleTile(),
                $this->newsArticleParser->getArticleImage(),
                $this->newsArticleParser->getArticleBody(),
            ]);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), [$articleLink]);
        }
    }
}
