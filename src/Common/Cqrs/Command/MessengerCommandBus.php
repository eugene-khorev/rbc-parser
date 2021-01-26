<?php


namespace App\Common\Cqrs\Command;

use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerCommandBus
 * Command bus that uses Symfony Messenger component to dispatch commands
 * @package App\Common\Cqrs\Command
 */
final class MessengerCommandBus implements CommandBusInterface
{

    /**
     * MessengerCommandBus constructor.
     * @param MessageBusInterface $commandBus Symfony Messenger component bus interface
     */
    public function __construct(
        private MessageBusInterface $commandBus
    ) {}

    /**
     * Dispatch command to bus by using Symfony Messenger component
     * @param CommandInterface $command Command to dispatch
     */
    public function dispatch(CommandInterface $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
