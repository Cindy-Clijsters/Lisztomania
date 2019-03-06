<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Update a user
 *
 * @author Cindy Clijsters
 */
class UpdateController extends AbstractController
{
    /**
     * Update the information of a user
     * 
     * @Route("/admin/users/update/{id}", name="rtAdminUserUpdate")
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function update(int $id): Response
    {
        return $this->render(
            'user/update.html.twig'
        );
    }
}
