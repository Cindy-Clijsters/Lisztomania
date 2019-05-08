<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Album;
use App\Entity\Label;
use App\Entity\Artist;
use App\Entity\Distributor;

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
     * @param array $filterParams
     * 
     * @return Query
     */
    public function findNonDeletedQuery(array $filterParams): Query
    {
        $query = $this->createQueryBuilder('a')
                       ->leftJoin('a.artist', 'artist');
                
        if (array_key_exists('searchValue', $filterParams)) {
            $query = $query->andWhere('a.title LIKE :searchValue OR a.alternativeTitle LIKE :searchValue')
                           ->setParameter('searchValue', '%' . addcslashes($filterParams['searchValue'], '%_') . '%');
        }
        
        if (array_key_exists('multipleArtists', $filterParams)) {
            $query = $query->andWhere('a.multipleArtists = :multipleArtists')
                           ->setParameter('multipleArtists', $filterParams['multipleArtists']);
        }
        
        if (array_key_exists('artist', $filterParams)) {
            $query = $query->andWhere('a.artist = :artist')
                           ->setParameter('artist', $filterParams['artist']);
        }
        
        if (array_key_exists('label', $filterParams)) {
            $query = $query->andWhere('a.label = :label')
                           ->setParameter('label', $filterParams['label']);
        }
        
        if (array_key_exists('distributor', $filterParams)) {
            $query = $query->andWhere('a.distributor = :distributor')
                           ->setParameter('distributor', $filterParams['distributor']);
        }
        
        if (array_key_exists('releaseYear', $filterParams)) {
            $query = $query->andWhere('a.releaseYear = :releaseYear')
                           ->setParameter('releaseYear', $filterParams['releaseYear']);
        }  
        
        if (array_key_exists('status', $filterParams)) {
            $query = $query->andWhere('a.status = :status')
                           ->setParameter('status', $filterParams['status']);
        }           
        
        $query = $query->orderBy('artist.sortName', 'ASC')
                       ->getQuery();
        
        return $query;
    }
    
    /**
     * Find an album by it's slug
     * 
     * @param string $slug
     * 
     * @return Album|null
     */
    public function findBySlug(string $slug): ?Album
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
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
            ->setParameter('label', $label)
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
            ->setParameter('artist', $artist)
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    /**
     * Count the albums of a specified distributor
     * 
     * @param Distributor $distributor
     * 
     * @return int
     */
    public function countAlbumsByDistributor(Distributor $distributor): int
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->andWhere('a.distributor = :distributor')
            ->setParameter('distributor', $distributor)
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    /**
     * Count the non-deleted albums
     * 
     * @return int
     */
    public function countNonDeletedAlbums(): int
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
