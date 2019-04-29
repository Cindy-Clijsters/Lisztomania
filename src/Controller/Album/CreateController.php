<?php
declare(strict_types = 1);

namespace App\Controller\Album;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\Album;
use App\Service\AlbumService;
use App\Form\Album\AlbumType;

/**
 * Create an album
 *
 * @author Cindy Clijsters
 */
class CreateController extends AbstractController
{
    private $albumSvc;
    private $translator;
    
    /**
     * Constructor
     * 
     * @param AlbumService $albumService
     * @param TranslatorInterface $translator
     */
    public function __construct(
        AlbumService $albumService,
        TranslatorInterface $translator
    ) {
        $this->albumSvc   = $albumService;
        $this->translator = $translator;
    }
    
    /**
     * Create a new album
     * 
     * @Route({
     *  "nl" : "/beheer/albums/toevoegen",
     *  "en" : "/admin/albums/add"
     * }, name="rtAdminAlbumCreate")
     * 
     * @param Request $request
     * 
     * @return Response
     */    
    public function create(Request $request): Response
    {
        // Generate the form
        $album = new Album();
        
        $form = $this->createForm(
            AlbumType::class,
            $album,
            ['validation_groups' => 'create']
        );
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Get the posted values
            $album = $form->getData();
            
            // Save the album            
            $this->albumSvc->saveToDb($album);
            
            // Redirect to the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.addedSuccessfully',
                    [
                        '%title%' => $album->getTitle()
                    ],
                    'albums'
                )
            );
            
            return $this->redirectToRoute('rtAdminAlbumOverview');
        }
        
        // Display the view
        return $this->render(
            'album/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );        
    }
}
