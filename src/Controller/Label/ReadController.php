<?php
declare(strict_types = 1);

namespace App\Controller\Label;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\LabelService;

/**
 * Read the information of a label
 *
 * @author Cindy Clijsters
 */
class ReadController extends AbstractController
{
    private $labelSvc;
    
    /**
     * Constructor function
     * 
     * @param LabelService $labelService
     */
    public function __construct(LabelService $labelService)
    {
        $this->labelSvc = $labelService;
    }
    
    /**
     * Read the information of a label
     * 
     * @Route(
     * {
     *  "nl" : "/beheer/labels/bekijken/{slug}",
     *  "en" : "/admin/labels/view/{slug}"
     * }, name="rtAdminLabelRead")
     * 
     * @param string $slug
     * 
     * @return Response
     */
    public function read(string $slug): Response
    {
        // Get the information to display the view
        $label = $this->labelSvc->findBySlug($slug);
        
        // Display the view
        return $this->render(
            'label/read.html.twig',
            [
                'label' => $label
            ]
        );
    }
}
