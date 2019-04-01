<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator
    ) {
        $this->em         = $entityManager;
        $this->translator = $translator;
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
     * Find an album by it's id
     * 
     * @param int $id
     * 
     * @return Album|null
     * @throws NotFoundHttpException
     */
    public function findById(int $id): ?Album
    {
        $albumRps = $this->getRepository();
        $album    = $albumRps->findById($id);
        
        // Display error message when album isn't found
        if (!$album) {
            throw new NotFoundHttpException(
                $this->translator->trans(
                    'error.noAlbumWithId',
                    ['%id%' => $id],
                    'albums'                       
                )
            );
        }
        
        // Return the album
        return $album;
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
