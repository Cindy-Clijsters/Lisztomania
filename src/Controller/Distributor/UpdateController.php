<?php
declare(strict_types = 1);

namespace App\Controller\Distributor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Update a distributor
 *
 * @author Cindy Clijsters
 */
class UpdateController extends AbstractController
{
    /**
     * Update a distributor
     * 
     * @Route({
     *  "nl" : "/beheer/distributeurs/wijzigen/{id}",
     *  "en" : "/admin/distributors/update/{id}"
     * }, name="rtAdminDistributorUpdate")
     * 
     * @return Response
     */
    public function update(): Response
    {
        // Display the view
        return $this->render(
            'distributor/update.html.twig'
        );        
    }
}
