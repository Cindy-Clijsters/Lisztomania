<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * Update the information of a user
     * 
     * @Route({
     *  "nl" : "/beheer/gebruikers/wijzigen/{slug}",
     *  "en" : "/admin/users/update/{slug}"
     * },  name="rtAdminUserUpdate")
     *
     * @IsGranted("ROLE_SUPERADMIN")
     * 
     * @param Request $request
     * @param string $slug
     * 
     * @return Response
     */
    public function update(Request $request, string $slug): Response
    {
        // Get the information to display the view
        $user = $this->userSvc->findBySlug($slug);
        
        $form = $this->createForm(UpdateType::class, $user);
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
