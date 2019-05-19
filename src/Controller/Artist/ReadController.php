<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\ArtistService;

/**
 * Read the information of a artist
 *
 * @author Cindy Clijsters
 */
class ReadController extends AbstractController
{
    private $artistSvc;
    
    /**
     * Constructor function
     * 
     * @param ArtistService $artistService
     */
    public function __construct(ArtistService $artistService)
    {
        $this->artistSvc = $artistService;
    }
    
    /**
     * Read the information of an artist
     * 
     * @Route({
     *  "nl" : "/beheer/artiesten/bekijken/{slug}",
     *  "en" : "/admin/artists/view/{slug}"
     * }, name="rtAdminArtistRead")
     * 
     * @param string $slug
     * 
     * @return Response
     */
    public function read(string $slug): Response
    {
        // Get the information to display the view
        $artist       = $this->artistSvc->findBySlug($slug);
        $translations = $this->artistSvc->findTranslations($artist);

        // Display the view
        return $this->render(
            'artist/read.html.twig',
            [
                'artist'       => $artist,
                'translations' => $translations
            ]
        );
    }
}