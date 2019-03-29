<?php
declare(strict_types = 1);

namespace App\Controller\Distributor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Create a distributor
 *
 * @author Cindy Clijsters
 */
class CreateController extends AbstractController
{
    /**
     * Create a new distributor
     * 
     * @Route({
     *  "nl" : "/beheer/distributeurs/toevoegen",
     *  "en" : "/admin/distributors/add"
     * }, name="rtAdminDistributorCreate")
     * 
     * @return Response
     */
    public function create(): Response
    {
        // Display the view
        return $this->render(
            'distributor/create.html.twig'
        );        
    }
}
