<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\Artist;
use App\Service\ArtistService;
use App\Service\AlbumService;

/**
 * Delete a artist
 *
 * @author Cindy Clijsters
 */
class DeleteController extends AbstractController
{
    private $artistSvc;
    private $albumSvc;
    private $em;
    private $translator;    
    
    /**
     * Constructor function
     * 
     * @param ArtistService $artistService
     * @param AlbumService $albumService
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     */
    public function __construct(
        ArtistService $artistService,
        AlbumService $albumService,
        EntityManagerInterface $em,
        TranslatorInterface $translator            
    ) {
        $this->artistSvc  = $artistService;
        $this->albumSvc   = $albumService;
        $this->em         = $em;
        $this->translator = $translator;        
    }
    
    /**
     * Delete a artist
     * 
     * @Route({
     *  "nl" : "/beheer/artiesten/verwijderen/{id}",
     *  "en" : "/admin/artists/delete/{id}"
     * }, name="rtAdminArtistDelete")
     * 
     * @param int $id
     * 
     * @return Response
     */
   public function delete(int $id): Response
   {
        // Get the information of the artist
        $artist = $this->artistSvc->findById($id);

        // Check if the artist is linked to an album
        $albumCount = $this->albumSvc->countAlbumsByArtist($artist);

        if ($albumCount === 0) {

            // Set the status to deleted
            $artist->setStatus(Artist::STATUS_DELETED);

            // Save the artist
            $this->em->persist($artist);
            $this->em->flush();
            
            // Redirect the the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.deletedSuccessfully',
                    [
                        '%name%' => $artist->getName()
                    ],
                    'artists'
                )
            );

            return $this->redirectToRoute('rtAdminArtistOverview');
        }
       
       // Display the message that label can't be deleted
       return $this->render(
           'artist/delete.html.twig'
       );
   }
}