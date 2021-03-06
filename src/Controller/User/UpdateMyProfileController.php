<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\User;
use App\Form\User\UpdateMyProfileType;
use App\Service\UserService;

/**
 * Update your own profile information
 *
 * @author Cindy Clijsters
 */
class UpdateMyProfileController extends AbstractController
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
     * Update your own profile information
     * 
     *  @Route({
     *  "nl" : "/beheer/mijn-profiel/wijzigen",
     *  "en" : "/admin/my-profile/update"
     * }, name="rtAdminMyProfileUpdate")
     * 
     * @param Request $request
     * 
     * @return Response
     */
    public function updateMyProfile(Request $request):Response
    {
        // Generate the form
        $user    = $this->getUser();
        $form    = $this->createForm(UpdateMyProfileType::class, $user);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Get the posted values
            $user = $form->getData();
            
            // Save the user
            $this->userSvc->saveToDb($user);
            
            // Redirect to the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.ownProfileUpdatedSuccessfully',
                    [],
                    'users'
                )
            );
            
            return $this->redirectToRoute('rtAdminMyProfile');
        }
        
        // Display the view
        return $this->render(      
            'user/updateMyProfile.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
