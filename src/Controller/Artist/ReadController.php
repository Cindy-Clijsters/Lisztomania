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
     * @Route(
     * {
     *  "nl" : "/beheer/artiesten/bekijken/{id}",
     *  "en" : "/admin/artists/view/{id}"
     * },
     * name="rtAdminArtistRead",
     * requirements={"id"="\d+"}
     * )
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function read(int $id): Response
    {
        // Get the information to display the view
        $artist = $this->artistSvc->findById($id);

        // Display the view
        return $this->render(
            'artist/read.html.twig',
            [
                'artist' => $artist
            ]
        );
    }
}