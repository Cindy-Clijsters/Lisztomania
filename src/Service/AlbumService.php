<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

use App\Entity\Album;
use App\Entity\Label;
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
     * @return object
     */
    private function getRepository()
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
}
