<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Service\UserService;
use App\Form\User\UpdateType;

/**
 * Update a user
 *
 * @author Cindy Clijsters
 */
class UpdateController extends AbstractController
{
    private $userSvc;
    private $em;
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param UserService $userService
     */
    public function __construct(
        UserService $userService,
        EntityManagerInterface $em,
        TranslatorInterface $translator
    ) {
        $this->userSvc    = $userService;
        $this->em         = $em;
        $this->translator = $translator;        
    }
    
    /**
     * Update the information of a user
     * 
     * @Route({
     *  "nl" : "/beheer/gebruikers/wijzigen/{id}",
     *  "en" : "/admin/users/update/{id}"
     * },  name="rtAdminUserUpdate")
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        // Get the information to display the view
        $user = $this->userSvc->findById($id);
        
        $form = $this->createForm(UpdateType::class, $user);
        $form->handleRequest($request);
                
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Get the posted values
            $user = $form->getData();
            
            // Save the user
            $this->em->persist($user);
            $this->em->flush();
            
            // Redirect to the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.changedSuccessfully',
                    [
                        '%username%' => $user->getFullName()
                    ],
                    'users'
                )
            );
            
            return $this->redirectToRoute('rtAdminUserOverview');
            
        }

        // Display the view
        return $this->render(
            'user/update.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
