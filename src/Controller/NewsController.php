<?php

namespace App\Controller;

use App\Common\Cqrs\Query\News\FindNewsArticleByIdQuery;
use App\Common\Cqrs\Query\News\GetLastNewsArticlesQuery;
use App\Common\Cqrs\Query\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * NewsController constructor.
     * @param QueryBusInterface $queryBus Query bus service
     */
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {}

    #[Route('/news', name: 'news_list')]
    public function index(): Response
    {
        $articles = $this->queryBus->handle(
            new GetLastNewsArticlesQuery(15),
        );

        return $this->render('news/article_list.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/news/{id}', name: 'news_details')]
    public function details(int $id): Response
    {
        $article = $this->queryBus->handle(
            new FindNewsArticleByIdQuery($id),
        );

        return $this->render('news/article_details.html.twig', [
            'article' => $article
        ]);
    }
}
