<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\User;
use App\Service\UserService;
use App\Form\User\ConfirmPasswordType;

/**
 * Delete a user
 *
 * @author Cindy Clijsters
 */
class DeleteController extends AbstractController
{
    private $userSvc;
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param UserService $userService
     * @param TranslatorInterface $translator
     */
    public function __construct(
        UserService $userService,
        TranslatorInterface $translator
    ) {
        $this->userSvc    = $userService;
        $this->translator = $translator;
    }
    
    /**
     * Delete the information of a user
     * 
     * @Route(
     * {
     *   "nl" : "/beheer/gebruikers/verwijderen/{id}",
     *   "en" : "/admin/users/delete/{id}"
     * },
     * name="rtAdminUserDelete",
     * requirements={"id"="\d+"}
     * )
     * 
     * @IsGranted("ROLE_SUPERADMIN")
     * 
     * @param Request $request
     * @param int $id
     * 
     * @return Response
     */
    public function delete(Request $request, int $id): Response
    {
        // Get the information of the user
        $user = $this->userSvc->findById($id);
        
        // Check if there are superadmins left after deletion
        $error = '';
        
        if ($user->getRole() === User::ROLE_SUPERADMIN) {
            
            $superadminsLeft = $this->userSvc->countActiveSuperadminsAfterDeletion($user);
            
            if ($superadminsLeft === 0) {
                $error = $this->translator->trans(
                    'deleteUser.onlySuperadminError',
                    [
                        '%fullName%' => $user->getFullName(),
                        '%username%' => $user->getUsername()
                    ],
                    'users'
                );
            }
        }
        
        // Generate the form
        $form = $this->createForm(
            ConfirmPasswordType::class,
            $user,
            ['validation_groups' => 'confirmPassword']
        );
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Get the posted values
            $user = $form->getData();
            
            // Set the status to deleted
            $user->setStatus(User::STATUS_DELETED);
            
            // Save the user
            $this->userSvc->saveToDb($user);
            
            // Redirect to the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.deletedSuccessfully',
                    [
                        '%fullName%' => $user->getFullName(),
                        '%username%' => $user->getUsername()
                    ],
                    'users'
                )
            );
                
            return $this->redirectToRoute('rtAdminUserOverview');
        }
                
        // Display the view
        return $this->render(
            'user/delete.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
                'error' => $error
            ]
        );
    }
}
