<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Label;

/**
 * @method Label|null find($id, $lockMode = null, $lockVersion = null)
 * @method Label|null findOneBy(array $criteria, array $orderBy = null)
 * @method Label[]    findAll()
 * @method Label[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LabelRepository extends ServiceEntityRepository
{
    /**
     * Constructor function
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Label::class);
    }

    /**
     * Get the non-deleted labels
     * 
     * @return Query
     */
    public function findNonDeletedQuery(): Query
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.status != :deletedStatus')
            ->setParameter('deletedStatus', Label::STATUS_DELETED)
            ->orderBy('l.name', 'ASC')
            ->getQuery();
    }
    
    /**
     * Check if the name if unique (without deleted labels)
     * 
     * @param array $criteria
     * 
     * @return type
     */
    public function findNonDeletedForConstraint(array $criteria)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.name = :name')
            ->andWhere('l.status != :deletedStatus')
            ->setParameter('name', $criteria['name'])
            ->setParameter('deletedStatus', Label::STATUS_DELETED)
            ->getQuery()
            ->getResult();
    }
    
    /**
     * Get an array with the active labels
     * 
     * @return array
     */
    public function findActive(): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.status = :activeStatus')
            ->setParameter('activeStatus', Label::STATUS_ACTIVE)
            ->orderBy('l.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * Find a label by it's id
     * 
     * @param int $id
     * 
     * @return Label|null
     */
    public function findById(int $id): ?Label
    {
        return $this->createQueryBuilder('l') 
            ->andWhere('l.id = :id')
            ->andWhere('l.status != :deletedStatus')
            ->setParameter('id', $id)
            ->setParameter('deletedStatus', Label::STATUS_DELETED)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
