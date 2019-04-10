<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Swift_Mailer;
use Swift_Message;

use App\Entity\User;
use App\Service\UserService;
use App\Service\EncryptionService;
use App\Form\User\ForgotYourPasswordType;

/**
 * Request a link for resetting your password
 *
 * 
 * @author Cindy Clijsters
 */
class ForgotYourPasswordController extends AbstractController
{
    private $userSvc;
    private $encryptionSvc;
    private $router;
    private $mailer;
    
    /**
     * Constructor function
     * 
     * @param UserService $userService
     * @param EncryptionService $encryptionService
     * @param UrlGeneratorInterface $router
     * @param Swift_Mailer $mailer
     */
    public function __construct(
        UserService $userService,
        EncryptionService $encryptionService,
        UrlGeneratorInterface $router,
        Swift_Mailer $mailer
    ){
        $this->userSvc       = $userService;
        $this->encryptionSvc = $encryptionService;
        $this->router        = $router;
        $this->mailer        = $mailer;
    }
    
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
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Find the user
            $data = $form->getData();           
            $user = $this->userSvc->findAdminByUsernameOrEmail($data['usernameOrEmail']);
                
            // Send an mail to the user
            $message = $this->generateMailMessage($user);

            // Send the e mail
            $this->mailer->send($message);
            
            return $this->render(
                'user/sendResetPasswordLink.html.twig'
            );

        }
        
        // Display the view
        return $this->render(
            'user/forgotYourPassword.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
    
    /**
     * Generate the mail for resetting your password
     * 
     * @param User $user
     * 
     * @return Swift_Message
     */
    private function generateMailMessage(User $user): Swift_Message
    {
        $identifier = $this->getIdentifier($user);
        $link       = $this->getResetPasswordLink($identifier);
                        
        $message = (new Swift_Message('Forgot your password'))
            ->setFrom('cindy.clijsters@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'emails/forgotYourPassword.html.twig',
                    [
                        'name' => $user->getFullName(),
                        'link' => $link
                    ]
                ),
                'text/html'
            );
        
        return $message;
    }
    
    /**
     * Get the user identifier
     * 
     * @param User $user
     * 
     * @return string
     */
    private function getIdentifier(User $user): string
    {
        return $this->encryptionSvc->encrypt(
            $user->getUsername(),
            $this->encryptionSvc::FORGOT_PASSWORD
        );
    }
    
    /**
     * Get the link to reset the password
     * 
     * @param string $identifier
     * 
     * @return string
     */
    private function getResetPasswordLink(string $identifier): string
    {
        return $this->router->generate(
            'rtAdminResetPassword',
            ['identifier' => $identifier],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}
