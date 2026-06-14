<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @return list<Event>
     */
    public function findHomepageSlider(int $limit = 8): array
    {
        return $this->createPublishedQueryBuilder(false)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return list<Event>
     */
    public function findPublishedActive(): array
    {
        return $this->createPublishedQueryBuilder(false)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return list<Event>
     */
    public function findPublishedArchived(): array
    {
        return $this->createPublishedQueryBuilder(true)
            ->getQuery()
            ->getResult();
    }

    private function createPublishedQueryBuilder(bool $archived): \Doctrine\ORM\QueryBuilder
    {
        return $this->createQueryBuilder('event')
            ->andWhere('event.published = :published')
            ->andWhere('event.archived = :archived')
            ->setParameter('published', true)
            ->setParameter('archived', $archived)
            ->orderBy('event.featured', 'DESC')
            ->addOrderBy('event.position', 'ASC')
            ->addOrderBy('event.eventDate', 'DESC')
            ->addOrderBy('event.id', 'DESC');
    }
}
