<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Delete a user
 *
 * @author Cindy Clijsters
 */
class DeleteController extends AbstractController
{
    /**
     * Delete the information of a user
     * 
     * @Route({
     *  "nl" : "/beheer/gebruikers/verwijderen/{id}",
     *  "en" : "/admin/users/delete/{id}"
     * }, name="rtAdminUserDelete")
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function delete(int $id): Response
    {
        return $this->render(
            'user/delete.html.twig'
        );
    }
}
