<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Service\EncryptionService;
use App\Service\UserService;
use App\Form\User\SetPasswordType;

/**
 * Reset your password
 *
 * @author Cindy Clijsters
 */
class ResetYourPasswordController extends AbstractController
{
    private $encryptionSvc;
    private $userSvc;
    
    /**
     * Constructor function
     * 
     * @param EncryptionService $encryptionService
     * @param UserService $userService
     */
    public function __construct(
        EncryptionService $encryptionService,
        UserService $userService
    ) {
        $this->encryptionSvc = $encryptionService;
        $this->userSvc       = $userService;
    }
    
    /**
     * Reset your password
     * 
     * @Route({
     *   "nl" : "/beheer/wachtwoord-resetten/{identifier}",
     *   "en" : "/admin/reset-password/{identifier}"
     * }, name="rtAdminResetPassword")
     * 
     * @param Request $request
     * @param string $identifier
     * 
     * @return Response
     */
    public function resetYourPassword(Request $request, string $identifier): Response
    {
        // Get the user by it's identifier
        $user = $this->userSvc->findAdminByIdentifier(
            $identifier,
            $this->encryptionSvc::FORGOT_PASSWORD
        );

        // Check if the user is confirmed
        if ($user->getStatus() === User::STATUS_UNCONFIRMED) {
            return $this->render('user/registrationUnconfirmed.html.twig');
        }

        // Generate the form
        $form = $this->createForm(
            SetPasswordType::class,
            $user,
            ['validation_groups' => 'resetPassword']
        );
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Get the posted values
            $user = $form->getData();
            
            // Hash the password 
            $hashedPassword = $this->userSvc->getHashedPassword($user);
            $user->setPassword($hashedPassword);
            
            // Save the user
            $this->userSvc->saveToDb($user);
            
            // Show success message
            return $this->render('user/passwordReset.html.twig');
            
        }
        
        // Display the view
        return $this->render(
            'user/resetYourPassword.html.twig',
            [
                'form' => $form->createView()
            ]
        );        
    }
}
