<?php


namespace App\Common\Parser;


interface DataProviderInterface
{
    public function getData(string $source): mixed;
}
