<?php


namespace App\Common\Cqrs\Command\News;


use App\Common\Cqrs\Command\CommandInterface;

final class ParseNewsArticleCommand implements CommandInterface
{

    public function __construct(
        private string $articleLink,
    ) {}

    public function getArticleLink(): string
    {
        return $this->articleLink;
    }

}
