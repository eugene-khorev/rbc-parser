<?php


namespace App\Common\Cqrs\Query\News;


use App\Common\Cqrs\Query\QueryHandlerInterface;
use App\Entity\NewsArticle;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FindArticleByUrlHandler
 * Handler that finds news articles by URL
 * @package App\Common\Cqrs\Query\News
 */
final class FindNewsArticleByUrlHandler implements QueryHandlerInterface
{
    /**
     * FindNewsArticleByUrlHandler constructor.
     * @param EntityManagerInterface $entityManager Doctrine entity manager
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    /**
     * Find news article by URL
     * @param FindNewsArticleByUrlQuery $query Query for finding news articles by URL
     * @return NewsArticle
     */
    public function __invoke(FindNewsArticleByUrlQuery $query): NewsArticle
    {
        // Get news article entity repository
        $repository = $this->entityManager->getRepository(NewsArticle::class);

        // Check if the article doesn't exists by its URL
        $article = $repository->findOneBy([
            'url' => $query->getUrl()
        ]);
        if (empty($article)) {
            // Create a new article entity
            $article = new NewsArticle;
        }

        return $article;
    }
}
