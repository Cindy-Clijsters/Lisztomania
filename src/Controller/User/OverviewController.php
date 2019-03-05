<?php

declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Show an overview of the users
 *
 * @author Cindy Clijsters
 */
class OverviewController extends AbstractController
{
    /**
     * Show an overview with the users
     * 
     * @Route("/admin/users/overview", name="rtAdminUserOverview")
     */
    public function overview():Response
    {
        // Display the view
        return $this->render(
            'user/overview.html.twig'
        );
    }
}
