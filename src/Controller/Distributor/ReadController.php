<?php
declare(strict_types = 1);

namespace App\Controller\Distributor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\DistributorService;

/**
 * Read the information of a distributor
 *
 * @author Cindy Clijsters
 */
class ReadController extends AbstractController
{
    private $distributorSvc;
    
    /**
     * Constructor function
     * 
     * @param DistributorService $distributorService
     */
    public function __construct(DistributorService $distributorService)
    {
        $this->distributorSvc = $distributorService;
    }
    
    /**
     * Read the information of a distributor
     * 
     * @Route({
     *  "nl" : "/beheer/distributeurs/bekijken/{id}",
     *  "en" : "/admin/distributors/view/{id}"
     * },
     * name = "rtAdminDistributorRead",
     * requirements = {"id" = "\d+"})
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function read(int $id): Response
    {
        // Get the info to display the view
        $distributor = $this->distributorSvc->findById($id);
        
        // Display the view
        return $this->render(
            'distributor/read.html.twig',
            [
                'distributor' => $distributor
            ]
        );        
    }
}
