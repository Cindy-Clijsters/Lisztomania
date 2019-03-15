<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Create a artist
 *
 * @author Cindy Clijsters
 */
class CreateController extends AbstractController
{
    /**
     * Create a new artist
     * 
     * @Route({
     *  "nl" : "/beheer/artiesten/toevoegen",
     *  "en" : "/admin/artists/add"
     * }, name="rtAdminArtistCreate")
     * 
     * @return Response
     */
   public function create(): Response
   {
       return $this->render(
           'artist/create.html.twig'
       );
   }
}
