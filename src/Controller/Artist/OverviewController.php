<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Artist;
use App\Service\ListService;

/**
 * Show an overview of the artists
 *
 * @author Cindy Clijsters
 */
class OverviewController extends AbstractController
{
    private $paginator;
    private $listSvc;
    
    /**
     * Constructor function
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
     * Show an overview of the artists
     * 
     * @Route({
     *  "nl" : "/beheer/artiesten/overzicht",
     *  "en" : "/admin/artists/overview"
     * }, name="rtAdminArtistOverview")
     * 
     * @param Request $request
     * 
     * @return Response
     */
    public function overview(Request $request):Response
    {
        // Get the page nr
        $pageNr = $request->query->getInt('page', 1);
        
        // Get the non-deleted artists
        $artistRps = $this->getDoctrine()->getRepository(Artist::class);
        $artistQry = $artistRps->findNonDeletedQuery();
        
        $artists = $this->paginator->paginate($artistQry, $pageNr, Artist::LIST_ITEMS);
        
        // Get the start- and end record for the shown items
        list($startRecord, $endRecord) = $this->listSvc->getStartEndRecord(
            $pageNr,
            Artist::LIST_ITEMS,
            $artists->getTotalItemCount()
        );
        
        // Display the view
        return $this->render(
            'artist/overview.html.twig',
            [
                'artists'     => $artists,
                'startRecord' => $startRecord,
                'endRecord'   => $endRecord
            ]
        );
    }
    
}
