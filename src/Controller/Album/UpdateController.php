<?php
declare(strict_types = 1);

namespace App\Controller\Album;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Translation\TranslatorInterface;

use App\Service\AlbumService;
use App\Form\AlbumType;

/**
 * Update an album
 *
 * @author Cindy Clijsters
 */
class UpdateController extends AbstractController
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
     * Update a album
     * 
     * @Route({
     *  "nl" : "/beheer/albums/wijzigen/{slug}",
     *  "en" : "/admin/albums/update/{slug}"
     * }, name="rtAdminAlbumUpdate")
     * 
     * @param Request $request
     * @param string $slug
     * 
     * @return Response
     */    
    public function update(Request $request, string $slug): Response
    {
        // Get the information to display the view
        $album = $this->albumSvc->findBySlug($slug);
        $form  = $this->createForm(AlbumType::class, $album, ['validation_groups' => 'update']);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Get the posted values
            $album = $form->getData();
            
            // Save the album
            $this->albumSvc->saveToDb($album);
            
            // Redirect the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.changedSuccessfully',
                    [
                        '%title%' => $album->getTitle()
                    ],
                    'albums'
                )
            );
            
            return $this->redirectToRoute("rtAdminAlbumOverview");
            
        }
        
        // Display the view
        return $this->render(
            'album/update.html.twig',
            [
                'form' => $form->createView()
            ]
        );        
    }
}
