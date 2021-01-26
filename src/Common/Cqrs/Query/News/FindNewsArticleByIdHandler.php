<?php


namespace App\Common\Cqrs\Query\News;


use App\Common\Cqrs\Query\QueryHandlerInterface;
use App\Entity\NewsArticle;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FindNewsArticleByIdHandler
 * Query for finding news articles by id
 * @package App\Common\Cqrs\Query\News
 */
class FindNewsArticleByIdHandler implements QueryHandlerInterface
{
    /**
     * FindNewsArticleByIdHandler constructor.
     * @param EntityManagerInterface $entityManager Doctrine entity manager
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    /**
     * Find news article by URL
     * @param FindNewsArticleByIdQuery $query Query for finding news articles by id
     * @return NewsArticle
     */
    public function __invoke(FindNewsArticleByIdQuery $query): NewsArticle
    {
        // Get news article entity repository
        $repository = $this->entityManager->getRepository(NewsArticle::class);

        return $repository->find(
            $query->getId(),
        );
    }

}
