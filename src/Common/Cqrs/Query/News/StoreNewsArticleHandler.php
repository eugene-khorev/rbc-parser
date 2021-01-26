<?php


namespace App\Common\Cqrs\Query\News;

use App\Common\Cqrs\Query\QueryHandlerInterface;
use App\Entity\NewsArticle;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class StoreNewsArticleHandler
 * Handler that stores news articles
 * @package App\Common\Cqrs\Query\News
 */
final class StoreNewsArticleHandler implements QueryHandlerInterface
{
    /**
     * StoreNewsArticleHandler constructor.
     * @param EntityManagerInterface $entityManager Doctrine entity manager
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    /**
     * Store news article
     * @param StoreNewsArticleQuery $query Query for storing news articles
     * @return NewsArticle
     */
    public function __invoke(StoreNewsArticleQuery $query): NewsArticle
    {
        // Get article entity
        $article = $query->getArticle();

        // Store article data
        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return $article;
    }
}
