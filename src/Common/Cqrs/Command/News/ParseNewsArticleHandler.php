<?php


namespace App\Common\Cqrs\Command\News;


use App\Common\Cqrs\Command\CommandHandlerInterface;
use App\Common\Cqrs\Query\News\FindNewsArticleByUrlQuery;
use App\Common\Cqrs\Query\News\StoreNewsArticleQuery;
use App\Common\Cqrs\Query\QueryBusInterface;
use App\Common\Parser\DataProviderInterface;
use App\Common\Parser\Html\NewsArticleParserInterface;
use App\Entity\NewsArticle;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ParseNewsArticleHandler
 * Handler that parses news articles
 * @package App\Common\Cqrs\Command\News
 */
final class ParseNewsArticleHandler implements CommandHandlerInterface
{
    /**
     * ParseNewsArticleHandler constructor.
     * @param LoggerInterface $logger Logger service
     * @param ValidatorInterface $validator Validator service
     * @param QueryBusInterface $queryBus Queue bus service
     * @param DataProviderInterface $dataProvider Data provider for parser
     * @param NewsArticleParserInterface $newsArticleParser News article parser service
     */
    public function __construct(
        private LoggerInterface $logger,
        private ValidatorInterface $validator,
        private QueryBusInterface $queryBus,
        private DataProviderInterface $dataProvider,
        private NewsArticleParserInterface $newsArticleParser,
    ) {}

    /**
     * Parse news article and store result
     * @param ParseNewsArticleCommand $command News article parsing command
     */
    public function __invoke(ParseNewsArticleCommand $command): void
    {
        // Get article URL form command
        $articleLink = $command->getArticleLink();
        try {
            // Get data to parse from URL
            $content = $this->dataProvider->getData($articleLink);

            // Prepare parser and store news article data
            $this->newsArticleParser->prepare($content);

            // Store article
            $article = $this->storeArticle(
                $articleLink,
                $this->newsArticleParser->getArticleDate(),
                $this->newsArticleParser->getArticleTile(),
                $this->newsArticleParser->getArticleImage(),
                $this->newsArticleParser->getArticleBody(),
            );

            $this->logger->info('News article parsed', [$article]            );
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), [$articleLink]);
        }
    }

    /**
     * Store news article via Doctrine entity repository
     * @param string $url Article URL
     * @param string $published_at Article publication date
     * @param string $title Article title
     * @param string $image_url Article image URL
     * @param string $body Article body
     * @return NewsArticle Article entity
     * @throws \Exception
     */
    private function storeArticle(
        string $url,
        string $published_at,
        string $title,
        string $image_url,
        string $body,
    ): NewsArticle
    {
        // Find article by URL
        $article = $this->queryBus->handle(
            new FindNewsArticleByUrlQuery($url)
        );

        // Set article fields
        $article->setUrl($url);
        $article->setPublishedAt(
            new \DateTime($published_at)
        );
        $article->setTitle($title);
        $article->setImageUrl($image_url);
        $article->setBody($body);

        // Validate news article entity
        $errors = $this->validator->validate($article);
        if (count($errors) > 0) {
            throw new ValidationFailedException($errors->get(0)->getInvalidValue(), $errors);
        }

        // Store article data
        $this->queryBus->handle(
            new StoreNewsArticleQuery($article)
        );

        return $article;
    }
}
