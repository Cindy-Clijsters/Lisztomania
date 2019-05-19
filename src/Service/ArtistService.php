<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity\Artist;
use App\Repository\ArtistRepository;

use Gedmo\Translatable\Entity\Translation;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;

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
     * Get the translation repository
     * 
     * @return Translation
     */
    public function getTranslationRepository(): TranslationRepository
    {
        return $this->em->getRepository('Gedmo\\Translatable\\Entity\\Translation');
    }
    
    /**
     * Get the query for finding the artists
     * 
     * @param string $searchValue
     * @param string $country
     * @param string $status
     * 
     * @return Query
     */
    public function findQuery(
        string $searchValue,
        string $country,
        string $status
    ): Query
    {
        $artistRps = $this->getRepository();
        $artistQry = $artistRps->findQuery($searchValue, $country, $status);
        
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
     * @param string $slug
     * 
     * @return Artist|null
     * @throws NotFoundHttpException
     */
    public function findBySlug(string $slug): ?Artist
    {
        $artistRps = $this->getRepository();
        $artist    = $artistRps->findBySlug($slug);
        
        if (!$artist) {
            throw new NotFoundHttpException(
                $this->translator->trans(
                    'error.noArtistWithSlug',
                    ['%slug%' => $slug],
                    'artists'
                )
            );
        }
        
        return $artist;
    } 
    
    /**
     * Find the translations
     * 
     * @param Artist $artist
     * 
     * @return array
     */
    public function findTranslations(Artist $artist): array
    {
        $translationRps = $this->getTranslationRepository();
        $translations   = $translationRps->findTranslations($artist);
        
        if (!array_key_exists('nl', $translations)) {
            $translations['nl']['description'] = '';
        }
        
        if (!array_key_exists('en', $translations)) {
            $translations['en']['description'] = '';
        }
        
        return $translations;
    }
    
    /**
     * Save the artist into the database
     * 
     * @param Artist $artist
     * @param array $translations
     * 
     * @return void
     */
    public function saveToDb(Artist $artist, array $translations): void
    {
        // Get the translations repository
        $translationRps = $this->getTranslationRepository();
    
        // Add the description
        $artist->setDescription($translations['description']['nl']);
        $translationRps->translate($artist, 'description', 'nl', $translations['description']['nl']);
        $translationRps->translate($artist, 'description', 'en', $translations['description']['en']);
        
        // Save the artist
        $this->em->persist($artist);
        $this->em->flush();        
    }
    
    /**
     * Remove an artist from the db
     * 
     * @param Artist $artist
     * 
     * @return void
     */
    public function removeFromDb(Artist $artist): void
    {
        $artist->setSlug($artist->getSlug() . '_softdeleted_' . $artist->getId());
        $this->em->persist($artist);
        $this->em->flush();
        
        $this->em->remove($artist);
        $this->em->flush();
    }
    
    /**
     * Count the non-deleted artists
     * 
     * @return int
     */
    public function countNonDeletedArtists(): int
    {
        $artistRps = $this->getRepository();
        $amount  = $artistRps->countNonDeletedArtists();
        
        return $amount;
    }
}
