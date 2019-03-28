<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity\Artist;

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
     * @return object
     */
    public function getRepository()
    {
        return $this->em->getRepository(Artist::class);
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
