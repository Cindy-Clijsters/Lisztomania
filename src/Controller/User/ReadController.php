<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Read the information of  a user
 *
 * @author Cindy Clijsters
 */
class ReadController extends AbstractController
{
    /**
     * Read the information of a user
     * 
     * @Route("/admin/users/read/{id}", name="rtAdminUserRead")
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function read(int $id): Response
    {
        return $this->render(
            'user/read.html.twig'
        );
    }
}