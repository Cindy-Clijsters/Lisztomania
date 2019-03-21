<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Artist;
use App\Form\Artist\ArtistType;

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
     * @param Request $request
     * 
     * @return Response
     */
   public function create(Request $request): Response
   {
       // Generate the form
       $artist = new Artist();
       $form   = $this->createForm(ArtistType::class, $artist);
       
       $form->handleRequest($request);
       
       // Display the view
       return $this->render(
           'artist/create.html.twig',
            [
                'form' => $form->createView()
            ]
       );
   }
}
