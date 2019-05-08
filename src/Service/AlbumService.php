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
     * @param array $filterParams
     * 
     * @return Query
     */
    public function findNonDeletedQuery(array $filterParams): Query
    {
        $albumRps = $this->getRepository();
        $albumQry = $albumRps->findNonDeletedQuery($filterParams);
        
        return $albumQry;
    }
    
    /**
     * Find an album by it's slug
     * 
     * @param string $slug
     * 
     * @return Album|null
     * @throws NotFoundHttpException
     */
    public function findBySlug(string $slug): ?Album
    {
        $albumRps = $this->getRepository();
        $album    = $albumRps->findBySlug($slug);
        
        // Display error message when album isn't found
        if (!$album) {
            throw new NotFoundHttpException(
                $this->translator->trans(
                    'error.noAlbumWithSlug',
                    ['%slug%' => $slug],
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
    
    /**
     * Get the range of the release years
     * 
     * @return array
     */
    public function getReleaseYearRange(): array
    {
        return range(1950, date('Y') + 1);
    }
    
    /**
     * Get the array of the release years
     * 
     * @return array
     */
    public function getReleaseYearArray(): array
    {
        $range = $this->getReleaseYearRange();
        
        return array_combine($range, $range);
    }
    
    /**
     * Save the album in the database
     * 
     * @param Album $album
     * 
     * @return void
     */
    public function saveToDb(Album $album): void
    {
        $this->em->persist($album);
        $this->em->flush();
    }
    
    /**
     * Remove the album from the db
     * 
     * @param Album $album
     * 
     * @return void
     */
    public function removeFromDb(Album $album)
    {
        $album->setSlug($album->getSlug() . '_softdeleted_' . $album->getId());
        $this->em->persist($album);
        $this->em->flush();
        
        $this->em->remove($album);
        $this->em->flush();
    }
    
    /**
     * Get the amount of albums by status
     * 
     * @return int
     */
    public function countNonDeletedAlbums(): int
    {
        $albumRps = $this->getRepository();
        $amount   = $albumRps->countNonDeletedAlbums();
        
        return $amount;
    }
}
