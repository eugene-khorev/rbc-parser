<?php


namespace App\Common\Cqrs\Command\News;


use App\Common\Cqrs\Command\CommandInterface;

/**
 * Class ParseNewsListCommand
 * Command for parsing news lists
 * @package App\Common\Cqrs\Command\News
 */
final class ParseNewsListCommand implements CommandInterface
{
    /**
     * ParseNewsListCommand constructor.
     * @param string $listLink News list URL
     */
    public function __construct(
        private string $listLink,
    ) {}

    /**
     * Return news list URL
     * @return string
     */
    public function getArticleLink(): string
    {
        return $this->listLink;
    }

}
