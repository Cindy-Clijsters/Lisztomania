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
     * Find a user by it's slug
     * 
     * @param string $slug
     * 
     * @return User|null
     */
    public function findBySlug(string $slug): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.slug = :slug')
            ->andWhere('u.status != :deletedStatus')
            ->setParameter('slug', $slug)
            ->setParameter('deletedStatus', User::STATUS_DELETED)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
     * Find a user by its username
     * 
     * @param string $username
     * 
     * @return User|null
     */
    public function findByUsername(string $username): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :username')
            ->andWhere('u.status != :deletedStatus')
            ->setParameter('username', $username)           
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
    
    /**
     * Count the number of superadmins after deleting the user
     * 
     * @param User $user
     * 
     * @return int
     */
    public function countActiveSuperadminsAfterDeletion(User $user): int
    {
        $amount = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->andWhere('u.id != :user')
            ->andWhere('u.role = :superadmin')
            ->andWhere('u.status = :activeStatus')
            ->setParameter('superadmin', User::ROLE_SUPERADMIN)
            ->setParameter('activeStatus', User::STATUS_ACTIVE)
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
        
        return intval($amount);
    }
    
    /**
     * Count the non-deleted users
     * 
     * @return int
     */
    public function countNonDeletedUsers(): int
    {
        $amount = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->andWhere('u.status != :deletedStatus')
            ->setParameter('deletedStatus', User::STATUS_DELETED)
            ->getQuery()
            ->getSingleScalarResult();
        
        return intval($amount);
    }
}
