<?php

namespace App\Repository;

use App\Entity\ContentApprovalRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ContentApprovalRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContentApprovalRequest::class);
    }

    /**
     * @return list<ContentApprovalRequest>
     */
    public function findPending(): array
    {
        return $this->findBy(['status' => ContentApprovalRequest::STATUS_PENDING], ['createdAt' => 'DESC']);
    }
}
