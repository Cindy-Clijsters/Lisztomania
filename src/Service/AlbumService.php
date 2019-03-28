<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Album;
use App\Entity\Label;

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
    public function getRepository()
    {
        return $this->em->getRepository(Album::class);
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
