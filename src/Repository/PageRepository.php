<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    /** @return Page[] */
    public function findPublished(): array
    {
        return $this->findBy(['published' => true], ['position' => 'ASC', 'title' => 'ASC']);
    }

    /** @return Page[] */
    public function findPublishedForHome(): array
    {
        return $this->createQueryBuilder('page')
            ->andWhere('page.published = :published')
            ->andWhere('page.slug != :donationSlug')
            ->setParameter('published', true)
            ->setParameter('donationSlug', Page::DONATION_SLUG)
            ->orderBy('page.position', 'ASC')
            ->addOrderBy('page.title', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
