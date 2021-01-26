<?php


namespace App\Common\Cqrs\Command;


interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}
