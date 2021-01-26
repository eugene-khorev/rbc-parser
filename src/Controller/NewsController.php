<?php

namespace App\Controller;

use App\Entity\NewsArticle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'news_list')]
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(NewsArticle::class);
        $articles = $repository->findAll();

        return $this->render('news/article_list.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/news/{id}', name: 'news_details')]
    public function details(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(NewsArticle::class);
        $article = $repository->find($id);

        return $this->render('news/article_details.html.twig', [
            'article' => $article
        ]);
    }
}
