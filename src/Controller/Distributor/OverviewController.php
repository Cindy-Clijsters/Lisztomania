<?php
declare(strict_types = 1);

namespace App\Controller\Distributor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Distributor;
use App\Form\Distributor\FilterType;
use App\Service\DistributorService;
use App\Service\ListService;

/**
 * Show an overview of all distributors
 *
 * @author Cindy Clijsters
 */
class OverviewController extends AbstractController
{
    private $paginator;
    private $distributorSvc;
    private $listSvc;
    
    /**
     * Constructor function
     * 
     * @param PaginatorInterface $paginator
     * @param DistributorSvc $distributorService
     * @param ListService $listService
     */
    public function __construct(
        PaginatorInterface $paginator,
        DistributorService $distributorService,
        ListService $listService
    ) {
        $this->paginator      = $paginator;
        $this->distributorSvc = $distributorService;
        $this->listSvc        = $listService;
    }
    
    /**
     * Show an overview of the distributors
     * 
     * @Route({
     *     "nl": "/beheer/distributeurs/overzicht",
     *     "en": "/admin/distributors/overview"
     * }, name="rtAdminDistributorOverview")
     * 
     * @param Request $request
     * 
     * @return Response
     */
    public function overview(Request $request): Response
    {        
        // Create the form for filtering distributors
        $form = $this->createForm(FilterType::class, null);
        $form->handleRequest($request);
        
        // Get the distributors
        $distributors = $this->getDistributors($request);
        
        // Get the start- and endrecord of the shown items
        list($startRecord, $endRecord) = $this->listSvc->getStartEndRecord(
            $request->query->getInt('page', 1),
            Distributor::LIST_ITEMS,
            $distributors->getTotalItemCount()
        );
                        
        // Display the view
        return $this->render(
            'distributor/overview.html.twig',
            [
                'form'         => $form->createView(),
                'distributors' => $distributors,
                'startRecord'  => $startRecord,
                'endRecord'    => $endRecord
            ]
        );
    }
    
    /**
     * Get the distributors
     * 
     * @param Request $request
     * 
     * @return object
     */
    private function getDistributors(Request $request): object
    {
         // Get the filter values
        $pageNr      = $request->query->getInt('page', 1);
        $searchValue = $request->query->get('searchValue', '');
        $status      = $request->query->get('status', '');
        
        // Get the non-deleted distributors
        $distributorQry = $this->distributorSvc->findNonDeletedQuery($searchValue, $status);
        $distributors   = $this->paginator->paginate($distributorQry, $pageNr, Distributor::LIST_ITEMS);
        
        return $distributors;
    }
}
