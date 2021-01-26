<?php


namespace App\Common\Cqrs\Query;

/**
 * Interface QueryBusInterface
 * Defines CQRS command bus interface
 * @package App\Common\Cqrs\Query
 */
interface QueryBusInterface
{
    /**
     * Handle query bus command
     * @param QueryInterface $query
     * @return mixed
     */
    public function handle(QueryInterface $query): mixed;
}
