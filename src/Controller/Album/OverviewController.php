<?php
declare(strict_types = 1);

namespace App\Controller\Album;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Show an overview of the albums
 *
 * @author Cindy Clijsters
 */
class OverviewController extends AbstractController
{
    /**
     * Show an overview of the albums
     * 
     * @Route("/admin/album/overview", name="rtAdminAlbumOverview")
     * 
     * @return Response
     */
    public function overview():Response
    {
        // Display the view
        return $this->render(
            'album/overview.html.twig'
        );
    }
}
