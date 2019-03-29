<?php
declare(strict_types = 1);

namespace App\Controller\Album;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Create an album
 *
 * @author Cindy Clijsters
 */
class CreateController extends AbstractController
{
    /**
     * Create a new album
     * 
     * @Route({
     *  "nl" : "/beheer/albums/toevoegen",
     *  "en" : "/admin/albums/add"
     * }, name="rtAdminAlbumCreate")
     * 
     * @return Response
     */    
    public function create(): Response
    {
        // Display the view
        return $this->render(
            'album/create.html.twig'
        );        
    }
}
