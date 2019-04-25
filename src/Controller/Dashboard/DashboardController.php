<?php
declare (strict_types = 1);

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\AlbumService;
use App\Service\ArtistService;
use App\Service\UserService;

/**
 * Dashboard page for the administration module
 *
 * @author Cindy Clijsters
 */
class DashboardController extends AbstractController
{
    private $userSvc;
    private $artistSvc;
    private $albumSvc;
    
    /**
     * Constructor function
     * 
     * @param UserService $userService
     * @param ArtistService $artistService
     * @param AlbumService $albumService
     */
    public function __construct(
        UserService $userService,
        ArtistService $artistService,
        AlbumService $albumService
    ) {
        $this->userSvc   = $userService;
        $this->artistSvc = $artistService;
        $this->albumSvc  = $albumService;
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
        // Get the amount of users, albums, ...
        $userAmount   = $this->userSvc->countNonDeletedUsers();
        $artistAmount = $this->artistSvc->countNonDeletedArtists();
        $albumAmount  = $this->albumSvc->countNonDeletedAlbums();
        
        // Display the view
        return $this->render(
            'dashboard/dashboard.html.twig',
            [
                'userAmount'   => $userAmount,
                'artistAmount' => $artistAmount,
                'albumAmount'  => $albumAmount
            ]
        );
    }
}
