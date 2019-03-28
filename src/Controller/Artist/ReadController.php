<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\Artist;

/**
 * Read the information of a artist
 *
 * @author Cindy Clijsters
 */
class ReadController extends AbstractController
{
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator) {
        $this->translator = $translator;
    }
    
    /**
     * Read the information of an artist
     * 
     * @Route({
     *  "nl" : "/beheer/artiesten/bekijken/{id}",
     *  "en" : "/admin/artists/view/{id}"
     * }, name="rtAdminArtistRead")
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function read(int $id): Response
    {
        // Get the information to display the view
        $artistRps = $this->getDoctrine()->getRepository(Artist::class);
        $artist    = $artistRps->findById($id);

        if (!$artist) {
            throw $this->createNotFoundException(
                $this->translator->trans(
                    'list.noArtistWithId',
                    ['%id%' => $id],
                    'artists'
                )
            );
        }

        // Display the view
        return $this->render(
            'artist/read.html.twig',
            [
                'artist' => $artist
            ]
        );
    }
}