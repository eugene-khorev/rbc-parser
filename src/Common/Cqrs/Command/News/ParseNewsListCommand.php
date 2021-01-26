<?php


namespace App\Common\Cqrs\Command\News;


use App\Common\Cqrs\Command\CommandInterface;

class ParseNewsListCommand implements CommandInterface
{
    public function __construct(
        private string $listLink,
    ) {}

    public function getArticleLink(): string
    {
        return $this->listLink;
    }

}
