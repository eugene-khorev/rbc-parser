<?php

namespace App\Command;

use App\Common\Cqrs\Command\CommandBusInterface;
use App\Common\Cqrs\Command\News\ParseNewsListCommand;
use App\Common\Cqrs\Query\QueryBusInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class ParseNewsCommand extends Command
{
    public function __construct(
        protected QueryBusInterface $queryBus,
        protected CommandBusInterface $commandBus,
        protected bool $requirePassword = false
    ) {
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
        $command = new ParseNewsListCommand('https://www.rbc.ru/');
        $this->commandBus->dispatch($command);

        return Command::SUCCESS;
    }
}
