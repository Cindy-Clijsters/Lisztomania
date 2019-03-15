<?php

namespace App\Repository;

use App\Entity\Artist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Artist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artist[]    findAll()
 * @method Artist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    /**
     * Get the non-deleted artists
     * 
     * @return Query
     */
    public function findNonDeletedQuery()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.status != :deletedStatus')
            ->setParameter('deletedStatus', Artist::STATUS_DELETED)
            ->orderBy('a.sortName', 'ASC')
            ->getQuery();
    }
}
