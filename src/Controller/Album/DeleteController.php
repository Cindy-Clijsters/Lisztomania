<?php
declare(strict_types = 1);

namespace App\Controller\Album;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Delete an album
 *
 * @author Cindy Clijsters
 */
class DeleteController extends AbstractController
{
    /**
     * Delete a album
     * 
     * @Route({
     *  "nl" : "/beheer/albums/verwijderen/{id}",
     *  "en" : "/admin/albums/delete/{id}"
     * }, name="rtAdminAlbumDelete")
     * 
     * @param int $id
     * 
     * @return Response
     */    
    public function delete(int $id): Response
    {
        // Display the view
        return $this->render(
            'album/delete.html.twig'
        );        
    }
}
