<?php

namespace App\Repository;

use App\Entity\AdminUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<AdminUser>
 */
class AdminUserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminUser::class);
    }

    public function loadUserByIdentifier(string $identifier): ?UserInterface
    {
        return $this->findOneBy(['email' => strtolower(trim($identifier)), 'active' => true]);
    }

    /**
     * @return list<AdminUser>
     */
    public function findPublicTeam(): array
    {
        $users = $this->findBy(['active' => true], ['name' => 'ASC']);
        usort($users, static function (AdminUser $first, AdminUser $second): int {
            $firstRank = $first->isSuperAdmin() ? 0 : 1;
            $secondRank = $second->isSuperAdmin() ? 0 : 1;

            return $firstRank <=> $secondRank ?: strcasecmp($first->getName(), $second->getName());
        });

        return array_values($users);
    }
}
