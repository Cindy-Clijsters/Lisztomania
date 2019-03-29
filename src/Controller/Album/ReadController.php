<?php
declare(strict_types = 1);

namespace App\Controller\Album;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * View the information of an album
 *
 * @author Cindy Clijsters
 */
class ReadController extends AbstractController
{
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
        // Display the view
        return $this->render(
            'album/read.html.twig'
        );
    }
}
