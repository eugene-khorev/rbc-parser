<?php

namespace App\Command;

use App\Common\Cqrs\Command\CommandBusInterface;
use App\Common\Cqrs\Command\News\ParseNewsListCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ParseNewsCommand
 * Dispatches news parsing command
 * @package App\Command
 */
class ParseNewsCommand extends Command
{
    public function __construct(
        protected CommandBusInterface $commandBus,
    ) {
        parent::__construct('app:parse-news');
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setDescription('News parser')
            ->setHelp('Parses www.rbc.ru news list.');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Create and dispatch news list parsing command
        $command = new ParseNewsListCommand('https://www.rbc.ru/');
        $this->commandBus->dispatch($command);

        return Command::SUCCESS;
    }
}
