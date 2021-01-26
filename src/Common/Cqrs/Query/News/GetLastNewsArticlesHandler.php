<?php


namespace App\Common\Cqrs\Query\News;


use App\Common\Cqrs\Query\QueryHandlerInterface;
use App\Entity\NewsArticle;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class GetLastNewsArticlesHandler
 * Handler that finds recent news articles
 * @package App\Common\Cqrs\Query\News
 */
class GetLastNewsArticlesHandler implements QueryHandlerInterface
{

    /**
     * GetLastNewsArticlesHandler constructor.
     * @param EntityManagerInterface $entityManager Doctrine entity manager
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    /**
     * Find recent news articles
     * @param GetLastNewsArticlesQuery $query
     * @return array<NewsArticle>
     */
    public function __invoke(GetLastNewsArticlesQuery $query): array
    {
        // Get news article entity repository
        $repository = $this->entityManager->getRepository(NewsArticle::class);

        // Find recent articles
        return $repository->findBy([], limit: $query->getLimit());
    }
}
