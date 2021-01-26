<?php


namespace App\Common\Cqrs\Command\News;


use App\Common\Cqrs\Command\CommandInterface;

/**
 * Class ParseNewsArticleCommand
 * Command for parsing news article
 * @package App\Common\Cqrs\Command\News
 */
final class ParseNewsArticleCommand implements CommandInterface
{

    /**
     * ParseNewsArticleCommand constructor.
     * @param string $articleLink News article URL
     */
    public function __construct(
        private string $articleLink,
    ) {}

    /**
     * Return news article URL
     * @return string
     */
    public function getArticleLink(): string
    {
        return $this->articleLink;
    }

}
