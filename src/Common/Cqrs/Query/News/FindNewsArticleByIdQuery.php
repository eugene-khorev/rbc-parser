<?php


namespace App\Common\Cqrs\Query\News;


use App\Common\Cqrs\Query\QueryInterface;

/**
 * Class FindNewsArticleByIdQuery
 * Query for finding news articles by URL
 * @package App\Common\Cqrs\Query\News
 */
class FindNewsArticleByIdQuery implements QueryInterface
{
    /**
     * FindNewsArticleByIdQuery constructor.
     * @param string $id News article id
     */
    public function __construct(
        private string $id,
    ) {}

    /**
     * Return id queue parameter
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
