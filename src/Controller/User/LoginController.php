<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Login form for the administraton module
 * 
 * @author Cindy Clijsters
 */
class LoginController extends AbstractController
{
    /**
     * Login in the administration module
     * 
     * @Route("/admin/login", name="rtAdminLogin")
     * 
     * @param AuthenticationUtils $authenticationUtils
     * 
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // Get the last email entered by the user
        $lastEmail = $authenticationUtils->getLastUsername();

        // Display the view
        return $this->render(
            'user/login.html.twig',
            [
                'lastEmail' => $lastEmail,
                'error'     => $error
            ]
        );
    }
}
