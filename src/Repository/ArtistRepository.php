<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Artist;

/**
 * @method Artist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artist[]    findAll()
 * @method Artist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistRepository extends ServiceEntityRepository
{
    /**
     * Constructor function
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    /**
     * Get the non-deleted artists
     * 
     * @return Query
     */
    public function findNonDeletedQuery(): Query
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.status != :deletedStatus')
            ->setParameter('deletedStatus', Artist::STATUS_DELETED)
            ->orderBy('a.sortName', 'ASC')
            ->getQuery();
    }
    
    /**
     * Get an array with active artists
     * 
     * @return array
     */
    public function findActive(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.status = :activeStatus')
            ->setParameter('activeStatus', Artist::STATUS_ACTIVE)
            ->orderBy('a.sortName', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * Check if the name is unique (without deleted artists)
     * 
     * @param array $criteria
     * 
     * @return array
     */
    public function findNonDeletedForConstraint(array $criteria): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.name = :name')
            ->andWhere('a.status != :deletedStatus')
            ->setParameter('name', $criteria['name'])
            ->setParameter('deletedStatus', Artist::STATUS_DELETED)
            ->getQuery()
            ->getResult();
    }
    
    /**
     * Find an artist by it's slug
     * 
     * @param string $slug
     * 
     * @return Artist|null
     */
    public function findBySlug(string $slug): ?Artist
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.slug = :slug')
            ->andWhere('a.status != :deletedStatus')
            ->setParameter('slug', $slug)
            ->setParameter('deletedStatus', Artist::STATUS_DELETED)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
     * Count the non-deleted artists
     * 
     * @return int
     */
    public function countNonDeletedArtists(): int
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->andWhere('a.status != :deletedStatus')
            ->setParameter('deletedStatus', Artist::STATUS_DELETED)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
