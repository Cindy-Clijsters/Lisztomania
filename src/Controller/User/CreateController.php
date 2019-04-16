<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Swift_Mailer;

use App\Entity\User;
use App\Form\User\CreateType;
use App\Service\EncryptionService;

/**
 * Create a new user
 *
 * @author Cindy Clijsters
 */
class CreateController extends AbstractController
{
    private $em;
    private $translator;
    private $encryptSvc;
    private $router;
    
    /**
     * Constructor function
     * 
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @param EncryptionService $encryptionService
     * @param UrlGeneratorInterface $router
     */
    public function __construct(
        EntityManagerInterface $em,
        TranslatorInterface $translator,
        EncryptionService $encryptionService,
        UrlGeneratorInterface $router    
    ) {
        $this->em         = $em;
        $this->translator = $translator;
        $this->encryptSvc = $encryptionService;
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
            $user->setStatus(User::STATUS_UNCONFIRMED);
            
            // Save the user
            $this->em->persist($user);
            $this->em->flush();
            
            // Send an mail to the new user
            $identifier = $this->encryptSvc->encrypt(
                $user->getUsername(),
                $this->encryptSvc::CONFIRM_REGISTRATION
            );
            
            $userEmail = $user->getEmail();
            
            $message = (new \Swift_Message('Set your password'))
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