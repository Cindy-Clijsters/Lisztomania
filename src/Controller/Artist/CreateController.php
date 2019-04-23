<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\Artist;
use App\Form\Artist\ArtistType;
use App\Service\ArtistService;

/**
 * Create a artist
 *
 * @author Cindy Clijsters
 */
class CreateController extends AbstractController
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
       
        if ($form->isSubmitted() && $form->isValid()) {
           
            // Get the posted values
            $artist = $form->getData();
           
            // Save the artist
            $this->artistSvc->saveToDb($artist);
           
            // Redirect to the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.addedSuccessfully',
                    [
                        '%name%' => $artist->getName()
                    ],
                    'artists'
                )
            );
           
            return $this->redirectToRoute('rtAdminArtistOverview');
           
        }
       
        // Display the view
        return $this->render(
            'artist/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
