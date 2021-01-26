<?php


namespace App\Common\Cqrs\Command;

/**
 * Interface CommandBusInterface
 * Defines CQRS command bus interface
 * @package App\Common\Cqrs\Command
 */
interface CommandBusInterface
{
    /**
     * Dispatch command to command bus
     * @param CommandInterface $command
     */
    public function dispatch(CommandInterface $command): void;
}
