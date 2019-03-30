<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

use App\Entity\Album;
use App\Entity\Label;
use App\Entity\Artist;
use App\Entity\Distributor;
use App\Repository\AlbumRepository;

/**
 * Hold album functions
 *
 * @author Cindy Clijsters
 */
class AlbumService
{
    private $em;
    
    /**
     * Constructor function
     * 
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    
    /**
     * Get the repository
     * 
     * @return AlbumRepository
     */
    private function getRepository(): AlbumRepository
    {
        return $this->em->getRepository(Album::class);
    }
    
    /**
     * Get the query to get the non deleted albums
     * 
     * @return Query
     */
    public function findNonDeletedQuery(): Query
    {
        $albumRps = $this->getRepository();
        $albumQry = $albumRps->findNonDeletedQuery();
        
        return $albumQry;
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
        $albumRps = $this->getRepository();
        $amount   = $albumRps->countAlbumsByLabel($label);
        
        return $amount;
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
        $albumRps = $this->getRepository();
        $amount   = $albumRps->countAlbumsByArtist($artist);
        
        return $amount;
    }
    
    /**
     * Count the albums of a specified distributor
     * 
     * @param \App\Service\Distributor $distributor
     * 
     * @return int
     */
    public function countAlbumsByDistributor(Distributor $distributor): int
    {
        $albumRps = $this->getRepository();
        $amount   = $albumRps->countAlbumsByDistributor($distributor);
        
        return $amount;
    }
}
