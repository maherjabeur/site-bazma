<?php

namespace App\Repository;

use App\Entity\Page;
use App\Entity\PageMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PageMedia>
 */
class PageMediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageMedia::class);
    }

    /**
     * @return list<PageMedia>
     */
    public function findForPage(Page $page): array
    {
        return $this->findBy(['page' => $page], ['position' => 'ASC', 'id' => 'ASC']);
    }
}
