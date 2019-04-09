<?php
declare(strict_types = 1);

namespace App\Controller\Album;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\Album;
use App\Service\AlbumService;

/**
 * Delete an album
 *
 * @author Cindy Clijsters
 */
class DeleteController extends AbstractController
{
    private $albumSvc;
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param AlbumService $albumService
     */
    public function __construct(
        AlbumService $albumService,
        TranslatorInterface $translator
    ) {
        $this->albumSvc   = $albumService;
        $this->translator = $translator;
    }
    
    /**
     * Delete a album
     * 
     * @Route({
     *  "nl" : "/beheer/albums/verwijderen/{id}",
     *  "en" : "/admin/albums/delete/{id}"
     * }, name="rtAdminAlbumDelete")
     * 
     * @param int $id
     * 
     * @return Response
     */    
    public function delete(int $id): Response
    {
        // Get the information of an album
        $album = $this->albumSvc->findById($id);
        
        // Set the status to deleted
        $album->setStatus(Album::STATUS_DELETED);
        
        // Save the album
        $this->albumSvc->saveToDb($album);
        
        // Redirect to the overview
        $this->addFlash(
            'notice',
            $this->translator->trans(
                'msg.deletedSuccessfully',
                [
                    '%title%' => $album->getTitle()
                ],
                'albums'
            )
        );
        
        return $this->redirectToRoute('rtAdminAlbumOverview');
    }
}
