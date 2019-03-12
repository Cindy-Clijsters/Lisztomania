<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Show your own profile
 *
 * @author Cindy Clijsters
 */
class ReadMyProfileController extends AbstractController
{
    /**
     * Show your own profile information
     * 
     * @Route({
     *  "nl" : "/beheer/mijn-profiel",
     *  "en" : "/admin/my-profile"
     * }, name="rtAdminMyProfile")
     * 
     * @return Response
     */
    public function myProfile():Response
    {
        // Get the information to display the view
        $user = $this->getUser();
        
        // Display the view
        return $this->render(
            'user/readMyProfile.html.twig',
            [
                'user' => $user
            ]
        );
    }
}
