<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * New users can set their password
 *
 * @author Cindy Clijsters
 */
class SetPasswordController extends AbstractController
{
    /**
     * New users can set their password
     * 
     * @Route({
     *  "nl" : "/gebruikers/wachtwoord-instellen/{identifier}",
     *  "en" : "/users/set-password/{identifier}"
     * }, name="rtUserSetPassword")
     * 
     * @return Response
     */
    public function setPassword(): Response
    {
        return $this->render(
            'user/setPassword.html.twig'
        );
    }
}
