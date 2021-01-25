<?php


namespace App\Common\Parser\Html;


interface ParserInterface
{
    /**
     * @param string $html
     * @throws ParserException
     */
    public function prepare(string $html): void;
}
