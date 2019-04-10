<?php
declare(strict_types = 1);

namespace App\Controller\Distributor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\Distributor;
use App\Form\Distributor\DistributorType;
use App\Service\DistributorService;

/**
 * Create a distributor
 *
 * @author Cindy Clijsters
 */
class CreateController extends AbstractController
{    
    private $distributorSvc;
    private $translator;
   
    /**
     * Constructor function
     * 
     * @param DistributorService $distributorService
     * @param TranslatorInterface $translator
     */
    public function __construct(
        DistributorService $distributorService,
        TranslatorInterface $translator
    ) {
        $this->distributorSvc = $distributorService;
        $this->translator     = $translator;
    }
    
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
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Get the posted values
            $distributor = $form->getData();
            
            // Save the distributor
            $this->distributorSvc->saveToDb($distributor);
            
            // Redirect to the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.addedSuccessfully',
                    [
                        '%name%' => $distributor->getName()
                    ],
                    'distributors'
                )
            );
            
            return $this->redirectToRoute('rtAdminDistributorOverview');
            
        }
        
        // Display the view
        return $this->render(
            'distributor/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
