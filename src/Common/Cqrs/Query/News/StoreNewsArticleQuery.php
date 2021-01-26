<?php


namespace App\Common\Cqrs\Query\News;

use App\Common\Cqrs\Query\QueryInterface;
use App\Entity\NewsArticle;

/**
 * Class StoreNewsArticleQuery
 * Query for storing news articles
 * @package App\Common\Cqrs\Query\News
 */
class StoreNewsArticleQuery implements QueryInterface
{
    /**
     * StoreNewsArticleQuery constructor.
     * @param NewsArticle $article News article to store
     */
    public function __construct(
        private NewsArticle $article,
    ) {}

    /**
     * Return article queue parameter
     * @return NewsArticle
     */
    public function getArticle(): NewsArticle
    {
        return $this->article;
    }

}
