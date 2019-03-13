<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\User;
use App\Form\User\CreateType;

/**
 * Create a new user
 *
 * @author Cindy Clijsters
 */
class CreateController extends AbstractController
{
    private $em;
    private $encoder;
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     * @param TranslatorInterface $translator
     */
    public function __construct(
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $encoder,
        TranslatorInterface $translator
    ) {
        $this->em         = $em;
        $this->encoder    = $encoder;
        $this->translator = $translator;
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
     * 
     * @return Response
     */
    public function create(Request $request): Response
    {
        // Generate the form
        $user = new User();
        $form = $this->createForm(CreateType::class, $user);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Get the posted values
            $user = $form->getData();
            
            // Encrypt the password
            $hashedPassword = $this->encoder->encodePassword(
                $user,
                $user->getPlainPassword()
            );
            
            $user->setPassword($hashedPassword);
            
            // Save the user
            $this->em->persist($user);
            $this->em->flush();
            
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