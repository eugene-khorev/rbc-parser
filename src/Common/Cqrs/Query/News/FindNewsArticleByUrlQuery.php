<?php


namespace App\Common\Cqrs\Query\News;

use App\Common\Cqrs\Query\QueryInterface;

/**
 * Class FindArticleByUrl
 * Query for finding news articles by URL
 * @package App\Common\Cqrs\Query\News
 */
final class FindNewsArticleByUrlQuery implements QueryInterface
{
    /**
     * FindArticleByUrlQuery constructor.
     * @param string $url News article URL
     */
    public function __construct(
        private string $url,
    ) {}

    /**
     * Return URL queue  parameter
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
