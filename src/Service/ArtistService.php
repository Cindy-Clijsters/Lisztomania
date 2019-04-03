<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity\Artist;
use App\Repository\ArtistRepository;

/**
 * Holds artist functions
 *
 * @author Cindy Clijsters
 */
class ArtistService
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
     * @return ArtistRepository
     */
    public function getRepository(): ArtistRepository
    {
        return $this->em->getRepository(Artist::class);
    }
    
    /**
     * Get the query for finding the non-deleted artists
     * 
     * @return Query
     */
    public function findNonDeletedQuery(): Query
    {
        $artistRps = $this->getRepository();
        $artistQry = $artistRps->findNonDeletedQuery();
        
        return $artistQry;
    }
    
    /**
     * Get an array with the active artists
     * 
     * @return array
     */
    public function findActive(): array
    {
        $artistRps = $this->getRepository();
        $artists   = $artistRps->findActive();
        
        return $artists;
    }
    
    /**
     * Find a artist by it's id
     * 
     * @param int $id
     * 
     * @return Artist|null
     * @throws NotFoundHttpException
     */
    public function findById(int $id): ?Artist
    {
        $artistRps = $this->getRepository();
        $artist    = $artistRps->findById($id);
        
        if (!$artist) {
            throw new NotFoundHttpException(
                $this->translator->trans(
                    'list.noArtistWithId',
                    ['%id%' => $id],
                    'artists'
                )
            );
        }
        
        return $artist;
    } 
}
