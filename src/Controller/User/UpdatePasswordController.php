<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Form\User\UpdatePasswordType;
use App\Service\UserService;

/**
 * Update your own password
 *
 * @author Cindy Clijsters
 */
class UpdatePasswordController extends AbstractController
{
    private $userSvc;
    private $translator;
    
    /**
     * Constructor
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
     * Update your password
     * 
     *  @Route({
     *  "nl" : "/beheer/mijn-profiel/wachtwoord-wijzigen",
     *  "en" : "/admin/my-profile/update-password"
     * }, name="rtAdminMyProfileUpdatePassword")
     * 
     * @param Request $request
     * 
     * @return Response
     */
    public function updatePassword(Request $request):Response
    {
        // Generate the form
        $user = $this->getUser();
        $form = $this->createForm(UpdatePasswordType::class, $user);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            // Get the posted data
            $user = $form->getData();

            // Hash the password
            $hashedPassword = $this->userSvc->getHashedPassword($user);
            $user->setPassword($hashedPassword);

            // Save the user
            $this->userSvc->saveToDb($user);

            // Redirect to the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.updatePasswordSucessfully',
                    [],
                    'users'
                )
            );

            return $this->redirectToRoute('rtAdminMyProfile');

        }
        
        return $this->render(      
            'user/updatePassword.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
