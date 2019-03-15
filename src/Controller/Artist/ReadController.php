<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Read the information of a artist
 *
 * @author Cindy Clijsters
 */
class ReadController extends AbstractController
{
    /**
     * Read the information of an artist
     * 
     * @Route({
     *  "nl" : "/beheer/artiesten/bekijken/{id}",
     *  "en" : "/admin/artists/view/{id}"
     * }, name="rtAdminArtistRead")
     * 
     * @return Response
     */
   public function read(int $id): Response
   {
       return $this->render(
           'artist/read.html.twig'
       );
   }
}