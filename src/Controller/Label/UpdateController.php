<?php
declare(strict_types = 1);

namespace App\Controller\Label;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Service\LabelService;
use App\Form\Label\LabelType;

/**
 * Update a label
 *
 * @author Cindy Clijsters
 */
class UpdateController extends AbstractController
{
    private $labelSvc;
    private $em;
    private $translator;

    /**
     * Constructor function
     * 
     * @param UserService $userService
     */
    public function __construct(
        LabelService $labelService,
        EntityManagerInterface $em,
        TranslatorInterface $translator
    ) {
        $this->labelSvc   = $labelService;
        $this->em         = $em;
        $this->translator = $translator;        
    }
    
    /**
     * Update a label
     * 
     * @Route({
     *  "nl" : "/beheer/labels/wijzigen/{id}",
     *  "en" : "/admin/labels/update/{id}"
     * }, name="rtAdminLabelUpdate")
     * 
     * @param Request $request
     * @param int $id
     * 
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        // Get the information to display the view
        $label = $this->labelSvc->findById($id);
        $form  = $this->createForm(LabelType::class, $label, ['validation_groups' => 'update']);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Get the posted values
            $label = $form->getData();
            
            // Save the label
            $this->em->persist($label);
            $this->em->flush();
            
            // Redirect to the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.changedSuccessfully',
                    [
                        '%name%' => $label->getName()
                    ],
                    'labels'
                )
            );
            
            return $this->redirectToRoute('rtAdminLabelOverview');
        }
        
        // Display the view
        return $this->render(
            'label/update.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
