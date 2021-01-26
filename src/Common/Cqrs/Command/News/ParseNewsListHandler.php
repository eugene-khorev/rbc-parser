<?php


namespace App\Common\Cqrs\Command\News;


use App\Common\Cqrs\Command\CommandBusInterface;
use App\Common\Cqrs\Command\CommandHandlerInterface;
use App\Common\Cqrs\Query\QueryBusInterface;
use App\Common\Parser\DataProviderInterface;
use App\Common\Parser\Html\NewsListParserInterface;
use Psr\Log\LoggerInterface;

final class ParseNewsListHandler implements CommandHandlerInterface
{
    public function __construct(
        private LoggerInterface $logger,
        protected QueryBusInterface $queryBus,
        protected CommandBusInterface $commandBus,
        private DataProviderInterface $dataProvider,
        private NewsListParserInterface $newsListParser,
    ) {}

    public function __invoke(ParseNewsListCommand $command): void
    {
        $content = $this->dataProvider->getData(
            $command->getArticleLink()
        );

        $this->newsListParser->prepare($content);
        $articleLinks = $this->newsListParser->getArticleLinks();
        foreach ($articleLinks as $articleLink) {
            $command = new ParseNewsArticleCommand($articleLink);
            $this->commandBus->dispatch($command);
        }

    }
}
