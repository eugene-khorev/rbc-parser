<?php

namespace App\Repository;

use App\Entity\NewsArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * News article Doctrine entity repository
 * @method NewsArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsArticle[]    findAll()
 * @method NewsArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsArticleRepository extends ServiceEntityRepository
{
    /**
     * NewsArticleRepository constructor.
     * @param ManagerRegistry $registry Doctrine entity manager
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsArticle::class);
    }

}
