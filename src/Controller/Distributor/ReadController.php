<?php
declare(strict_types = 1);

namespace App\Controller\Distributor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Read the information of a distributor
 *
 * @author Cindy Clijsters
 */
class ReadController extends AbstractController
{
    /**
     * Read the information of a distributor
     * 
     * @Route({
     *  "nl" : "/beheer/distributeurs/bekijken/{id}",
     *  "en" : "/admin/distributors/view/{id}"
     * }, name="rtAdminDistributorRead")
     * 
     * @return Response
     */
    public function read(): Response
    {
        // Display the view
        return $this->render(
            'distributor/read.html.twig'
        );        
    }
}
