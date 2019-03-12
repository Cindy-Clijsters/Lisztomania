<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\User\UpdateMyProfileType;

/**
 * Update your own profile information
 *
 * @author Cindy Clijsters
 */
class UpdateMyProfileController extends AbstractController
{
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
        $user = $this->getUser();
        $form = $this->createForm(UpdateMyProfileType::class, $user);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Get the posted values
            $user = $form->getData();
            
            var_dump($user);
            die();
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
