<?php
declare(strict_types = 1);

namespace App\Controller\Distributor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Service\DistributorService;
use App\Form\DistributorType;

/**
 * Update a distributor
 *
 * @author Cindy Clijsters
 */
class UpdateController extends AbstractController
{
    private $distributorSvc;
    private $em;
    private $translator;
    
    /**
     * Contructor function
     * 
     * @param DistributorService $distributorService
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     */
    public function __construct(
        DistributorService $distributorService,
        EntityManagerInterface $em,
        TranslatorInterface $translator
    ) {
        $this->distributorSvc = $distributorService;
        $this->em             = $em;
        $this->translator     = $translator;
    }
    
    /**
     * Update a distributor
     * 
     * @Route({
     *  "nl" : "/beheer/distributeurs/wijzigen/{id}",
     *  "en" : "/admin/distributors/update/{id}"
     * }, name="rtAdminDistributorUpdate")
     * 
     * @param Request $request
     * @param int $id
     * 
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        // Get the information to display the view
        $distributor = $this->distributorSvc->findById($id);
        
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
            $this->em->persist($distributor);
            $this->em->flush();
            
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
