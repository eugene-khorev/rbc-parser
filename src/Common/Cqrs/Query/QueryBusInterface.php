<?php


namespace App\Common\Cqrs\Query;


interface QueryBusInterface
{
    public function handle(QueryInterface $query): mixed;
}
