<?php
declare(strict_types = 1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\User;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * Constructor function
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Get the the non-deleted users
     * 
     * @return Query
     */
    public function findNonDeletedQuery(): Query
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.status != :deletedStatus')
            ->setParameter('deletedStatus', User::STATUS_DELETED)
            ->orderBy('u.lastName', 'ASC')
            ->addOrderBy('u.firstName', 'ASC')
            ->addOrderBy('u.email', 'ASC')
            ->getQuery();
    }
    
    /**
     * Check if the email is unique (without deleted users)
     * 
     * @param array $criteria
     * 
     * @return array
     */
    public function findNonDeletedForConstraint(array $criteria): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->andWhere('u.status != :deletedStatus')
            ->setParameter('email', $criteria['email'])
            ->setParameter('deletedStatus', User::STATUS_DELETED)
            ->getQuery()
            ->getResult();
    }
    
    /**
     * Find a user by it's id
     * 
     * @param int $id
     * 
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :id')
            ->andWhere('u.status != :deletedStatus')
            ->setParameter('id', $id)
            ->setParameter('deletedStatus', User::STATUS_DELETED)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
     * Find a administrator of superadministrator by its username or e-mail address
     * 
     * @param string $searchValue
     * 
     * @return User|null
     */
    public function findAdminByUsernameOrEmail(string $searchValue): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :username OR u.email = :email')
            ->andWhere('u.role = :admin OR u.role = :superadmin')
            ->andWhere('u.status != :deletedStatus')
            ->setParameter('username', $searchValue)
            ->setParameter('email', $searchValue)
            ->setParameter('admin', User::ROLE_ADMIN)
            ->setParameter('superadmin', User::ROLE_SUPERADMIN)                
            ->setParameter('deletedStatus', User::STATUS_DELETED)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
