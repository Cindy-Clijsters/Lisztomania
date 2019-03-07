<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\User;
use App\Form\User\LoginType;

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
     * @Route({
     *  "nl" : "/beheer/aanmelden",
     *  "en" : "/admin/login"
     * }, name="rtAdminLogin")
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
        
        // Generate the form
        $user = new User();
        $form = $this->createForm(
            LoginType::class,
            $user,
            ['lastEmail' => $lastEmail]
        );

        // Display the view
        return $this->render(
            'user/login.html.twig',
            [
                'form'      => $form->createView(),
                'error'     => $error
            ]
        );
    }
}
