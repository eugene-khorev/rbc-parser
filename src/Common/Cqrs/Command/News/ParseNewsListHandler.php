<?php


namespace App\Common\Cqrs\Command\News;


use App\Common\Cqrs\Command\CommandBusInterface;
use App\Common\Cqrs\Command\CommandHandlerInterface;
use App\Common\Cqrs\Query\QueryBusInterface;
use App\Common\Parser\DataProviderInterface;
use App\Common\Parser\Html\NewsListParserInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ParseNewsListHandler
 * Handler that parses news lists
 * @package App\Common\Cqrs\Command\News
 */
final class ParseNewsListHandler implements CommandHandlerInterface
{
    /**
     * ParseNewsListHandler constructor.
     * @param LoggerInterface $logger Logger service
     * @param QueryBusInterface $queryBus Query bus service
     * @param CommandBusInterface $commandBus Command bus service
     * @param DataProviderInterface $dataProvider Data provider for parser
     * @param NewsListParserInterface $newsListParser News list parser service
     */
    public function __construct(
        private LoggerInterface $logger,
        protected QueryBusInterface $queryBus,
        protected CommandBusInterface $commandBus,
        private DataProviderInterface $dataProvider,
        private NewsListParserInterface $newsListParser,
    ) {}

    /**
     * Parse news list and dispatch news article parsing command for each list item
     * @param ParseNewsListCommand $command News list parsing command
     */
    public function __invoke(ParseNewsListCommand $command): void
    {
        // Get data to parse from URL defined in command
        $content = $this->dataProvider->getData(
            $command->getArticleLink()
        );

        // Prepare parser and get list of news article URLs
        $this->newsListParser->prepare($content);
        $articleLinks = $this->newsListParser->getArticleLinks();

        // Dispatch news article parsing command for each item
        foreach ($articleLinks as $articleLink) {
            $command = new ParseNewsArticleCommand($articleLink);
            $this->commandBus->dispatch($command);
        }

    }
}
