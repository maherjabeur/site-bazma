<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EventRepository extends ServiceEntityRepository
{
    public const FRONT_ACTIVE_LIMIT = 10;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @return list<Event>
     */
    public function findHomepageSlider(int $limit = self::FRONT_ACTIVE_LIMIT): array
    {
        return $this->createPublishedQueryBuilder(false)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return list<Event>
     */
    public function findPublishedActive(int $limit = self::FRONT_ACTIVE_LIMIT): array
    {
        return $this->createPublishedQueryBuilder(false)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findPublicBySlug(string $slug): ?Event
    {
        return $this->createPublishedQueryBuilder(false)
            ->andWhere('event.slug = :slug')
            ->setParameter('slug', $slug)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
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

    public function archivePublishedOverflow(int $limit = self::FRONT_ACTIVE_LIMIT): int
    {
        if ($limit < 1) {
            return 0;
        }

        $activeEvents = $this->createActiveNewestQueryBuilder()
            ->getQuery()
            ->getResult();

        $archivedCount = 0;
        foreach (array_slice($activeEvents, $limit) as $event) {
            $event->setArchived(true);
            $archivedCount++;
        }

        return $archivedCount;
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

    private function createActiveNewestQueryBuilder(): \Doctrine\ORM\QueryBuilder
    {
        return $this->createQueryBuilder('event')
            ->andWhere('event.published = :published')
            ->andWhere('event.archived = :archived')
            ->setParameter('published', true)
            ->setParameter('archived', false)
            ->orderBy('event.eventDate', 'DESC')
            ->addOrderBy('event.id', 'DESC');
    }
}
