<?php


namespace App\Common\Cqrs\Query;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerQueryBus
 * Query bus that uses Symfony Messenger component to handle queries
 * @package App\Common\Cqrs\Query
 */
final class MessengerQueryBus implements QueryBusInterface
{

    /**
     * Use HandleTrait of Symfony Messenger component
     */
    use HandleTrait {
        handle as handleQuery;
    }

    /**
     * MessengerQueryBus constructor.
     * @param MessageBusInterface $queryBus Symfony Messenger component bus interface
     */
    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * Handle query from bus by using Symfony Messenger component
     * @param QueryInterface $query Query to handle
     * @return mixed
     */
    public function handle(QueryInterface $query): mixed
    {
        return $this->handleQuery($query);
    }
}
