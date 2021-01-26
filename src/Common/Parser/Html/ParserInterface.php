<?php


namespace App\Common\Parser\Html;

/**
 * Interface ParserInterface
 * Defines HTML parser interface
 * @package App\Common\Parser\Html
 */
interface ParserInterface
{
    /**
     * Prepare data to parse
     * @param string $html HTML to parse
     * @throws ParserException
     */
    public function prepare(string $html): void;
}
