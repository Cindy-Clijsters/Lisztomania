<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Distributor;

/**
 * @method Distributor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Distributor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Distributor[]    findAll()
 * @method Distributor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistributorRepository extends ServiceEntityRepository
{
    /**
     * Constructor function
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Distributor::class);
    }

    /**
     * Get the non-deleted distributors
     * 
     * @param string $searchValue
     * @param string $status
     * 
     * @return Query
     */
    public function findNonDeletedQuery(string $searchValue = '', string $status = ''): Query
    {
        $query = $this->createQueryBuilder('d')
            ->andWhere('d.status != :deletedStatus')
            ->setParameter('deletedStatus', Distributor::STATUS_DELETED);
        
        if ($searchValue !== '') {
            $query = $query->andWhere('d.name LIKE :searchValue')
                ->setParameter('searchValue', '%' . addcslashes($searchValue, '%_') . '%');
        }
        
        if ($status !== '') {
            $query = $query->andWhere('d.status = :searchStatus')
                ->setParameter('searchStatus', $status);
        }
        
        $query = $query->orderBy('d.name', 'ASC')
                    ->getQuery();
        
        return $query;
    }
    
    /**
     * Check if the name if unique (without deleted distributors)
     * 
     * @param array $criteria
     * 
     * @return array
     */
    public function findNonDeletedForConstraint(array $criteria): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.name = :name')
            ->andWhere('d.status != :deletedStatus')
            ->setParameter('name', $criteria['name'])
            ->setParameter('deletedStatus', Distributor::STATUS_DELETED)
            ->getQuery()
            ->getResult();
    }    
    
    /**
     * Get an array with the active distributors
     * 
     * @return array
     */
    public function findActive(): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.status = :activeStatus')
            ->setParameter('activeStatus', Distributor::STATUS_ACTIVE)
            ->orderBy('d.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * Find a distributor by it's slug
     * 
     * @param string $slug
     * 
     * @return Distributor|null
     */
    public function findBySlug(string $slug): ?Distributor
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.slug = :slug')
            ->andWhere('d.status != :deletedStatus')
            ->setParameter('slug', $slug)
            ->setParameter('deletedStatus', Distributor::STATUS_DELETED)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
