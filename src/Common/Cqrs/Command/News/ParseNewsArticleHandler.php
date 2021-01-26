<?php


namespace App\Common\Cqrs\Command\News;


use App\Common\Cqrs\Command\CommandHandlerInterface;
use App\Common\Parser\DataProviderInterface;
use App\Common\Parser\Html\NewsArticleParserInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ParseNewsArticleHandler
 * Handler that parses news articles
 * @package App\Common\Cqrs\Command\News
 */
final class ParseNewsArticleHandler implements CommandHandlerInterface
{
    /**
     * ParseNewsArticleHandler constructor.
     * @param LoggerInterface $logger Logger service
     * @param DataProviderInterface $dataProvider Data provider for parser
     * @param NewsArticleParserInterface $newsArticleParser News article parser service
     */
    public function __construct(
        private LoggerInterface $logger,
        private DataProviderInterface $dataProvider,
        private NewsArticleParserInterface $newsArticleParser
    ) {}

    /**
     * Parse news article and store result
     * @param ParseNewsArticleCommand $command News article parsing command
     */
    public function __invoke(ParseNewsArticleCommand $command): void
    {
        // Get article URL form command
        $articleLink = $command->getArticleLink();
        try {
            // Get data to parse from URL
            $content = $this->dataProvider->getData($articleLink);

            // Prepare parser and store news article data
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
