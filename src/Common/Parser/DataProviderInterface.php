<?php


namespace App\Common\Parser;

/**
 * Interface DataProviderInterface
 * Defines parser data provider interface
 * @package App\Common\Parser
 */
interface DataProviderInterface
{
    /**
     * Return data to parse
     * @param string $source
     * @return mixed
     */
    public function getData(string $source): mixed;
}
