<?php
declare(strict_types = 1);

namespace App\Controller\Label;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Label;
use App\Form\Label\FilterType;
use App\Service\LabelService;
use App\Service\ListService;

/**
 * Show an overview of the users
 *
 * @author Cindy Clijsters
 */
class OverviewController extends AbstractController
{
    private $paginator;
    private $labelSvc;
    private $listSvc;
    
    /**
     * Constructor function
     * 
     * @param PaginatorInterface $paginator
     * @param LabelService $labelService
     * @param ListService $listService
     */
    public function __construct(
        PaginatorInterface $paginator,
        LabelService $labelService,
        ListService $listService
    ) {
        $this->paginator = $paginator;
        $this->labelSvc  = $labelService;
        $this->listSvc   = $listService;
    }
    
    /**
     * Show an overview of the labels
     * 
     * @Route({
     *     "nl": "/beheer/labels/overzicht",
     *     "en": "/admin/labels/overview"
     * }, name="rtAdminLabelOverview")
     * 
     * @param Request $request
     * 
     * @return Response
     */
    public function overview(Request $request): Response
    {
        // Create the form for filtering labels
        $form = $this->createForm(FilterType::class, null);
        $form->handleRequest($request);
        
        // Get the page nr
        $pageNr = $request->query->getInt('page', 1);
        
        // Get the non-deleted labels        
        $labels = $this->getLabels($request, $pageNr);
        
        // Get the start- and end record of the shown items
        list($startRecord, $endRecord) = $this->listSvc->getStartEndRecord(
            $pageNr,
            Label::LIST_ITEMS,
            $labels->getTotalItemCount()
        );
        
        // Display the view
        return $this->render(
            'label/overview.html.twig',
            [
                'form'        => $form->createView(),
                'labels'      => $labels,
                'startRecord' => $startRecord,
                'endRecord'   => $endRecord
            ]
        );
    }
    
    /**
     * Get the labels
     * 
     * @param Request $request
     * 
     * @return object
     */
    private function getLabels(Request $request, int $pageNr): object
    {
        $searchValue = $request->query->get('searchValue', '');
        $status      = $request->query->get('status', '');
        
        $labelsQry = $this->labelSvc->findNonDeletedQuery($searchValue, $status);
        $labels    = $this->paginator->paginate($labelsQry, $pageNr, Label::LIST_ITEMS);
        
        return $labels;
    }
}
