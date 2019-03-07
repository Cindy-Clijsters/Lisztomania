<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Form\User\CreateType;

/**
 * Create a new user
 *
 * @author Cindy Clijsters
 */
class CreateController extends AbstractController
{
    /**
     * Create a new user
     * 
     * @Route({
     *  "nl" : "/beheer/gebruikers/toevoegen",
     *  "en" : "/admin/users/add"
     * }, name="rtAdminUserCreate")
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
        
        // Dislay the view
        return $this->render(
            'user/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}