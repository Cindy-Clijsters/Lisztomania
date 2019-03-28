<?php
namespace App\Repository;

use App\Entity\Label;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Label|null find($id, $lockMode = null, $lockVersion = null)
 * @method Label|null findOneBy(array $criteria, array $orderBy = null)
 * @method Label[]    findAll()
 * @method Label[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LabelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Label::class);
    }

    /**
     * Get the non-deleted labels
     * 
     * @return Object
     */
    public function findNonDeletedQuery()
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.status != :deletedStatus')
            ->setParameter('deletedStatus', Label::STATUS_DELETED)
            ->orderBy('l.name', 'ASC')
            ->getQuery();
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
