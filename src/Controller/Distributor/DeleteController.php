<?php
declare(strict_types = 1);

namespace App\Controller\Distributor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Delete a distributor
 *
 * @author Cindy Clijsters
 */
class DeleteController extends AbstractController
{
    /**
     * Delete a distributor
     * 
     * @Route({
     *  "nl" : "/beheer/distributeurs/verwijderen/{id}",
     *  "en" : "/admin/distributors/delete/{id}"
     * }, name="rtAdminDistributorDelete")
     * 
     * @return Response
     */
    public function delete(): Response
    {
        // Display the view
        return $this->render(
            'distributor/delete.html.twig'
        );          
    }
}
