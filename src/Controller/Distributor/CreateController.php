<?php
declare(strict_types = 1);

namespace App\Controller\Distributor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Distributor;
use App\Form\DistributorType;

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
     * @param Request $request
     * 
     * @return Response
     */
    public function create(Request $request): Response
    {
        // Generate the form
        $distributor = new Distributor();
        
        $form = $this->createForm(
            DistributorType::class,
            $distributor,
            ['validation_groups' => 'create']
        );
        
        $form->handleRequest($request);
        
        // Display the view
        return $this->render(
            'distributor/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
