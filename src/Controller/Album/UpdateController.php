<?php
declare(strict_types = 1);

namespace App\Controller\Album;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Update an album
 *
 * @author Cindy Clijsters
 */
class UpdateController extends AbstractController
{
    /**
     * Update a album
     * 
     * @Route({
     *  "nl" : "/beheer/albums/wijzigen/{id}",
     *  "en" : "/admin/albums/update/{id}"
     * }, name="rtAdminAlbumUpdate")
     * 
     * @param int $id
     * 
     * @return Response
     */    
    public function update(int $id): Response
    {
        // Display the view
        return $this->render(
            'album/update.html.twig'
        );        
    }
}
