<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Update your own profile information
 *
 * @author Cindy Clijsters
 */
class UpdateMyProfileController extends AbstractController
{
    /**
     * Update your own profile information
     * 
     *  @Route({
     *  "nl" : "/beheer/mijn-profiel/wijzigen",
     *  "en" : "/admin/my-profile/update"
     * }, name="rtAdminMyProfileUpdate")
     * 
     * @return Response
     */
    public function updateMyProfile():Response
    {
        return $this->render(      
            'user/updateMyProfile.html.twig'
        );
    }
}
