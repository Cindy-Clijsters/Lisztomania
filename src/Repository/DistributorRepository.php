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
     * @return Query
     */
    public function findNonDeletedQuery(): Query
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.status != :deletedStatus')
            ->setParameter('deletedStatus', Distributor::STATUS_DELETED)
            ->orderBy('d.name', 'ASC')
            ->getQuery();
    }
}
