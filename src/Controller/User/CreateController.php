<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @return Response
     */
    public function create(): Response
    {
        return $this->render(
            'user/create.html.twig'
        );
    }
}