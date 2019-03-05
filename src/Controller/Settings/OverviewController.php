<?php
declare(strict_types = 1);

namespace App\Controller\Settings;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Show an overview of the settings
 *
 * @author Cindy Clijsters
 */
class OverviewController extends AbstractController
{
    /**
     * Show an overview with the settings
     * 
     * @Route("/admin/settings/overview", name="rtAdminSettingsOverview")
     * 
     * @return Response
     */
    public function overview():Response
    {
        // Display the view
        return $this->render(
            'settings/overview.html.twig'
        );        
    }
}
