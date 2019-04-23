<?php
declare (strict_types = 1);

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\AlbumService;

/**
 * Dashboard page for the administration module
 *
 * @author Cindy Clijsters
 */
class DashboardController extends AbstractController
{
    private $albumSvc;
    
    /**
     * Constructor function
     * 
     * @param AlbumService $albumService
     */
    public function __construct(
        AlbumService $albumService
    ) {
        $this->albumSvc = $albumService;
    }
    
    /**
     * Show the dashboard page of the administration module
     * 
     * @Route({
     *      "nl" : "/beheer/dashboard",
     *      "en" : "/admin/dashboard"
     *  }, name="rtAdminDashboard")
     * 
     * @return Response
     */
    public function dashboard(): Response
    {
        // Get the amount of albums
        $albumAmounts = $this->albumSvc->countAlbumsByStatus();
        
        // Display the view
        return $this->render(
            'dashboard/dashboard.html.twig',
            [
                'albumAmounts' => $albumAmounts
            ]
        );
    }
}
