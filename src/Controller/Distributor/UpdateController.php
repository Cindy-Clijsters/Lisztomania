<?php
declare(strict_types = 1);

namespace App\Controller\Distributor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Service\DistributorService;
use App\Form\Distributor\DistributorType;

/**
 * Update a distributor
 *
 * @author Cindy Clijsters
 */
class UpdateController extends AbstractController
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
     * Update a distributor
     * 
     * @Route({
     *  "nl" : "/beheer/distributeurs/wijzigen/{slug}",
     *  "en" : "/admin/distributors/update/{slug}"
     * }, name="rtAdminDistributorUpdate")
     * 
     * @param Request $request
     * @param string $slug
     * 
     * @return Response
     */
    public function update(Request $request, string $slug): Response
    {
        // Get the information to display the view
        $distributor = $this->distributorSvc->findBySlug($slug);
        
        $form = $this->createForm(
            DistributorType::class,
            $distributor,
            ['validation_groups' => 'update']
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
                    'msg.changedSuccessfully',
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
            'distributor/update.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
