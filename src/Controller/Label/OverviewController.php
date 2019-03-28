<?php
declare(strict_types = 1);

namespace App\Controller\Label;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Label;
use App\Service\ListService;

/**
 * Show an overview of the users
 *
 * @author Cindy Clijsters
 */
class OverviewController extends AbstractController
{
    private $paginator;
    private $listSvc;
    
    /**
     * Contructor function
     * 
     * @param PaginatorInterface $paginator
     * @param ListService $listService
     */
    public function __construct(
        PaginatorInterface $paginator,
        ListService $listService
    ) {
        $this->paginator = $paginator;
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
        // Get the page nr
        $pageNr = $request->query->getInt('page', 1);
        
        // Get the non-deleted labels
        $labelRps  = $this->getDoctrine()->getRepository(Label::class);
        $labelsQry = $labelRps->findNonDeletedQuery();
        
        $labels = $this->paginator->paginate($labelsQry, $pageNr, Label::LIST_ITEMS);
        
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
                'labels'      => $labels,
                'startRecord' => $startRecord,
                'endRecord'   => $endRecord
            ]
        );
    }
}
