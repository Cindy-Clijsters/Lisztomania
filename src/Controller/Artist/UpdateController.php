<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Translation\TranslatorInterface;

use App\Form\Artist\ArtistType;
use App\Service\ArtistService;

/**
 * Update a artist
 *
 * @author Cindy Clijsters
 */
class UpdateController extends AbstractController
{
    private $artistSvc;
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param ArtistService $artistService
     * @param TranslatorInterface $translator
     */
    public function __construct(
        ArtistService $artistService,
        TranslatorInterface $translator
    ) {
        $this->artistSvc  = $artistService;
        $this->translator = $translator;
    }
    
    /**
     * Update an artist
     * 
     * @Route({
     *  "nl" : "/beheer/artiesten/wijzigen/{id}",
     *  "en" : "/admin/artists/update/{id}"
     * }, name="rtAdminArtistUpdate")
     * 
     * @param Request $request
     * @param int $id
     * 
     * @return Response
     */
   public function update(Request $request, int $id): Response
   {
       // Get the information to display the view
       $artist = $this->artistSvc->findById($id);
       
       $form = $this->createForm(
            ArtistType::class,
            $artist,
            ['validation_groups' => 'update']
        );
       $form->handleRequest($request);
       
       if ($form->isSubmitted() && $form->isValid()) {
           
            // Get the posted values
            $artist = $form->getData();
           
            // Save the artist
            $this->artistSvc->saveToDb($artist);
           
            // Redirect to the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.changedSuccessfully',
                    [
                        '%name%' => $artist->getName()
                    ], 
                    'artists'
                )
            );
           
            return $this->redirectToRoute("rtAdminArtistOverview");
       }
       
       // Display the view
       return $this->render(
           'artist/update.html.twig',
            [
                'form' => $form->createView()
            ]
       );
   }
}