<?php

namespace App\Repository;

use App\Entity\Feed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FeedRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Feed::class);
    }

    public function findByCategory($category)
    {
        return $this->createQueryBuilder('feed')
            ->where('feed.category = :value')->setParameter('value', $category)
            ->getQuery()
            ->getResult();
    }
}
