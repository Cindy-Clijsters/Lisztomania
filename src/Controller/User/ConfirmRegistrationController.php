<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Service\EncryptionService;
use App\Service\UserService;
use App\Form\User\SetPasswordType;

/**
 * New users can confirm their registration
 *
 * @author Cindy Clijsters
 */
class ConfirmRegistrationController extends AbstractController
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
     * New users can set confirm their registration
     * 
     * @Route({
     *  "nl" : "/gebruikers/registratie-bevestigen/{identifier}",
     *  "en" : "/users/confirm-registration/{identifier}"
     * }, name="rtUserConfirmRegistration")
     * 
     * @param Request $request
     * @param string $identifier
     * 
     * @return Response
     */
    public function confirmRegistration(Request $request, string $identifier): Response
    {
        // Find the user by the identifier
        $user = $this->userSvc->findByIdentifier(
            $identifier,
            $this->encryptionSvc::CONFIRM_REGISTRATION
        );
       
        // Check if the user is confirmed
        if ($user->getStatus() !== User::STATUS_UNCONFIRMED) {
            return $this->render('user/registrationAlreadyConfirmed.html.twig');
        }
        
        // Generate the form
        $form = $this->createForm(
            SetPasswordType::class,
            $user,
            ['validation_groups' => 'confirmRegistration']
        );
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Get the posted values
            $user = $form->getData();
            
            // Hash the password + set status to active
            $hashedPassword = $this->userSvc->getHashedPassword($user);
            
            $user->setPassword($hashedPassword);
            $user->setStatus(User::STATUS_ACTIVE);
            
            // Save the user
            $this->userSvc->saveToDb($user);
            
            // Show the success message
            return $this->render('user/registrationConfirmed.html.twig');
        }
                
        // Get the user by it's identifier
        return $this->render(
            'user/confirmRegistration.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
