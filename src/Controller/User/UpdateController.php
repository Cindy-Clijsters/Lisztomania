<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    
    /**
     * Constructor function
     * 
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userSvc = $userService;
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
    public function update(int $id): Response
    {
        // Get the information to display the view
        $user = $this->userSvc->findById($id);
        
        $form = $this->createForm(UpdateType::class, $user);

        // Display the view
        return $this->render(
            'user/update.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
