<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Update a artist
 *
 * @author Cindy Clijsters
 */
class UpdateController extends AbstractController
{
    /**
     * Update a new artist
     * 
     * @Route({
     *  "nl" : "/beheer/artiesten/wijzigen/{id}",
     *  "en" : "/admin/artists/update/{id}"
     * }, name="rtAdminArtistUpdate")
     * 
     * @param int $id
     * 
     * @return Response
     */
   public function update(int $id): Response
   {
       return $this->render(
           'artist/update.html.twig'
       );
   }
}