<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Update your own password
 *
 * @author Cindy Clijsters
 */
class UpdatePasswordController extends AbstractController
{
    /**
     * Update your password
     * 
     *  @Route({
     *  "nl" : "/beheer/mijn-profiel/wachtwoord-wijzigen",
     *  "en" : "/admin/my-profile/update-password"
     * }, name="rtAdminMyProfileUpdatePassword")
     * 
     * @return Response
     */
    public function updatePassword():Response
    {
        return $this->render(      
            'user/updatePassword.html.twig'
        );
    }
}
