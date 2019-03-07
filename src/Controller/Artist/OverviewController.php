<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Show an overview of the artists
 *
 * @author Cindy Clijsters
 */
class OverviewController extends AbstractController
{
    /**
     * Show an overview of the artists
     * 
     * @Route({
     *  "nl" : "/beheer/artiesten/overzicht",
     *  "en" : "/admin/artists/overview"
     * }, name="rtAdminArtistOverview")
     * 
     * @return Response
     */
    public function overview():Response
    {
        // Display the view
        return $this->render(
            'artist/overview.html.twig'
        );
    }
}
