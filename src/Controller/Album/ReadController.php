<?php
declare(strict_types = 1);

namespace App\Controller\Album;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\AlbumService;

/**
 * View the information of an album
 *
 * @author Cindy Clijsters
 */
class ReadController extends AbstractController
{
    private $albumSvc;
    
    /**
     * Constructor function
     * 
     * @param AlbumService $albumService
     */
    public function __construct(AlbumService $albumService)
    {
        $this->albumSvc = $albumService;
    }
    
    /**
     * View the information of an album
     * 
     * @Route({
     *  "nl" : "/beheer/albums/bekijken/{id}",
     *  "en" : "/admin/albums/view/{id}"
     * }, name="rtAdminAlbumRead")
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function read(int $id): Response
    {
        // Get the information to display the view
        $album = $this->albumSvc->findById($id);
        
        // Display the view
        return $this->render(
            'album/read.html.twig',
            [
                'album' => $album
            ]
        );
    }
}
