<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Swift_Mailer;

use App\Entity\User;
use App\Form\User\CreateType;
use App\Service\EncryptionService;
use App\Service\UserService;

/**
 * Create a new user
 *
 * @author Cindy Clijsters
 */
class CreateController extends AbstractController
{
    private $userSvc;    
    private $encryptSvc;
    private $translator;    
    private $router;

    
    /**
     * Constructor function
     * 
     * @param UserService $userService
     * @param EncryptionService $encryptionService
     * @param TranslatorInterface $translator
     * @param UrlGeneratorInterface $router
     */
    public function __construct(
        UserService $userService,
        EncryptionService $encryptionService,    
        TranslatorInterface $translator,
        UrlGeneratorInterface $router    
    ) {
        $this->userSvc    = $userService;
        $this->encryptSvc = $encryptionService;
        $this->translator = $translator;
        $this->router     = $router;
    }
    
    /**
     * Create a new user
     * 
     * @Route({
     *  "nl" : "/beheer/gebruikers/toevoegen",
     *  "en" : "/admin/users/add"
     * }, name="rtAdminUserCreate")
     * 
     * @IsGranted("ROLE_SUPERADMIN")
     * 
     * @param Request $request
     * @param Swift_Mailer $mailer
     * 
     * @return Response
     */
    public function create(Request $request, \Swift_Mailer $mailer): Response
    {
        // Generate the form
        $user = new User();
        $form = $this->createForm(CreateType::class, $user);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Get the posted values
            $user = $form->getData();
            
            // Set the status to unconfirmed
            $user->setStatus(User::STATUS_UNCONFIRMED);
            
            // Save the user
            $this->userSvc->saveToDb($user);
            
            // Send an mail to the new user
            $identifier = $this->encryptSvc->encrypt(
                $user->getUsername(),
                $this->encryptSvc::CONFIRM_REGISTRATION
            );
            
            $userEmail = $user->getEmail();
            
            $message = (new \Swift_Message($this->translator->trans('action.confirmRegistration', [], 'users')))
                ->setFrom('cindy.clijsters@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/setPassword.html.twig',
                        [
                            'name' => $user->getFullName(),
                            'link' => $this->router->generate('rtUserConfirmRegistration', ['identifier' => $identifier], UrlGeneratorInterface::ABSOLUTE_URL)
                        ]
                    ),
                    'text/html'
                );
            
            $mailer->send($message);
            
            // Redirect to the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.addedSuccessfully',
                    [
                        '%username%' => $user->getFullName()
                    ],
                    'users'
                )
            );
            
            return $this->redirectToRoute('rtAdminUserOverview');
            
        }
        
        // Dislay the view
        return $this->render(
            'user/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}