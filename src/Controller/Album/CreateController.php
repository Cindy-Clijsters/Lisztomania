<?php
declare(strict_types = 1);

namespace App\Controller\Album;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Album;
use App\Service\AlbumService;
use App\Form\AlbumType;

/**
 * Create an album
 *
 * @author Cindy Clijsters
 */
class CreateController extends AbstractController
{
    private $albumSvc;
    
    /**
     * Constructor
     * 
     * @param AlbumService $albumService
     */
    public function __construct(AlbumService $albumService)
    {
        $this->albumSvc = $albumService;
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
        
        // Display the view
        return $this->render(
            'album/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );        
    }
}
