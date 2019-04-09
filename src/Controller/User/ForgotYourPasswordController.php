<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\User\ForgotYourPasswordType;

/**
 * Request a link for resetting your password
 *
 * @author Cindy Clijsters
 */
class ForgotYourPasswordController extends AbstractController
{
    /**
     * Request a link for resetting your password
     * 
     * @Route({
     *  "nl" : "/beheer/wachtwoord-vergeten",
     *  "en" : "/admin/forgot-your-password"
     * }, name = "rtAdminForgotYourPassword")
     * 
     * @param Request $request
     * 
     * @return Response
     */
    public function forgotYourPassword(Request $request): Response
    {
        // Get the information to display the form
        $form = $this->createForm(ForgotYourPasswordType::class);
        $form->handleRequest($request);
        
        // Display the view
        return $this->render(
            'user/forgotYourPassword.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
