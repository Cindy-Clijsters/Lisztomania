<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\UserService;

/**
 * Read the information of  a user
 *
 * @author Cindy Clijsters
 */
class ReadController extends AbstractController
{
    private $userSvc;
    
    /**
     * Constructor function
     * 
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userSvc = $userService;
    }
    
    /**
     * Read the information of a user
     * 
     * @Route({
     *  "nl" : "/beheer/gebruikers/bekijken/{id}",
     *  "en" : "/admin/users/view/{id}"
     * }, name="rtAdminUserRead")
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function read(int $id): Response
    {
        // Get the information to display the view
        $user = $this->userSvc->findById($id);
        
        // Display the view
        return $this->render(
            'user/read.html.twig',
            [
                'user' => $user
            ]
        );
    }
}