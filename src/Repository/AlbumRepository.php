<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Album;
use App\Entity\Label;
use App\Entity\Artist;

/**
 * @method Album|null find($id, $lockMode = null, $lockVersion = null)
 * @method Album|null findOneBy(array $criteria, array $orderBy = null)
 * @method Album[]    findAll()
 * @method Album[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumRepository extends ServiceEntityRepository
{
    /**
     * Constructor function
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Album::class);
    }
    
    /**
     * Get the non-deleted albums
     * 
     * @return Query
     */
    public function findNonDeletedQuery(): Query
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.artist', 'artist')
            ->andWhere('a.status != :deletedStatus')
            ->setParameter('deletedStatus', Album::STATUS_DELETED)
            ->orderBy('artist.sortName', 'ASC')
            ->getQuery();
    }

    /**
     * Count the albums of a specified label
     * 
     * @param Label $label
     * 
     * @return int
     */
    public function countAlbumsByLabel(Label $label): int
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->andWhere('a.label = :label')
            ->andWhere('a.status != :deletedStatus')
            ->setParameter('label', $label)
            ->setParameter('deletedStatus', Album::STATUS_DELETED)
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    /**
     * Count the albums of a specified artist
     * 
     * @param Artist $artist
     * 
     * @return int
     */
    public function countAlbumsByArtist(Artist $artist): int
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->andWhere('a.artist = :artist')
            ->andWhere('a.status != :deletedStatus')
            ->setParameter('artist', $artist)
            ->setParameter('deletedStatus', Album::STATUS_DELETED)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
