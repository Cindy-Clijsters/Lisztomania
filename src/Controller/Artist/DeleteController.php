<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Delete a artist
 *
 * @author Cindy Clijsters
 */
class DeleteController extends AbstractController
{
    /**
     * Delete a new artist
     * 
     * @Route({
     *  "nl" : "/beheer/artiesten/verwijderen/{id}",
     *  "en" : "/admin/artists/delete/{id}"
     * }, name="rtAdminArtistDelete")
     * 
     * @return Response
     */
   public function delete(int $id): Response
   {
       return $this->render(
           'artist/delete.html.twig'
       );
   }
}