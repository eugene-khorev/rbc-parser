<?php


namespace App\Common\Cqrs\Query\News;

use App\Common\Cqrs\Query\QueryInterface;

/**
 * Class GetLastNewsArticlesQuery
 * Query for finding recent news articles
 * @package App\Common\Cqrs\Query\News
 */
final class GetLastNewsArticlesQuery implements QueryInterface
{
    /**
     * GetLastNewsArticlesQuery constructor.
     * @param int $limit Number of recent news articles to find
     */
    public function __construct(
        private int $limit,
    ) {}

    /**
     * Return limit queue parameter
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

}
