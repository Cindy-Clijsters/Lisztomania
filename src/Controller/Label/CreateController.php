<?php
declare(strict_types = 1);

namespace App\Controller\Label;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\Label;
use App\Form\Label\LabelType;
use App\Service\LabelService;

/**
 * Create a label
 *
 * @author Cindy Clijsters
 */
class CreateController extends AbstractController
{
    private $labelSvc;
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param LabelService $labelService
     * @param TranslatorInterface $translator
     */
    public function __construct(
        LabelService $labelService,
        TranslatorInterface $translator
    ){
        $this->labelSvc   = $labelService;
        $this->translator = $translator;
    }
    
    /**
     * Create a new label
     * 
     * @Route({
     *  "nl" : "/beheer/labels/toevoegen",
     *  "en" : "/admin/labels/add"
     * }, name="rtAdminLabelCreate")
     * 
     * @param Request $request
     * 
     * @return Response
     */
    public function create(Request $request): Response
    {
        // Generate the form
        $label = new Label();
        $form  = $this->createForm(LabelType::class, $label);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Get the posted values
            $label = $form->getData();
            
            // Save the label
            $this->labelSvc->saveToDb($label);
            
            // Redirect to the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.addedSuccessfully',
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
            'label/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );        
    }
}
