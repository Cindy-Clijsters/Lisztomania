<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Artist;
use App\Form\Artist\FilterType;
use App\Service\ArtistService;
use App\Service\ListService;

/**
 * Show an overview of the artists
 *
 * @author Cindy Clijsters
 */
class OverviewController extends AbstractController
{
    private $paginator;
    private $artistSvc;
    private $listSvc;
    
    /**
     * Constructor function
     * 
     * @param PaginatorInterface $paginator
     * @param ArtistService $artistService
     * @param ListService $listService
     */
    public function __construct(
        PaginatorInterface $paginator,
        ArtistService $artistService,
        ListService $listService
    ) {
        $this->paginator = $paginator;
        $this->artistSvc = $artistService;
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
        // Create the form for filtering artists
        $form = $this->createForm(FilterType::class, null);
        $form->handleRequest($request);
        
        // Get the page nr
        $pageNr = $request->query->getInt('page', 1);
        
        // Get the non-deleted artists
        $artists = $this->getArtists($request, $pageNr);
        
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
                'form'        => $form->createView(),
                'artists'     => $artists,
                'startRecord' => $startRecord,
                'endRecord'   => $endRecord
            ]
        );
    }
    
    /**
     * Get the artists
     * 
     * @param Request $request
     * @param int $pageNr
     * 
     * @return object
     */
    private function getArtists(Request $request, int $pageNr): object
    {
        // Get the filter values
        $searchValue = $request->query->get('searchValue', '');
        $country     = $request->query->get('country', '');
        $status      = $request->query->get('status', '');
        
        // Get the artists
        $artistsQry = $this->artistSvc->findQuery($searchValue, $country, $status);
        $artists    = $this->paginator->paginate($artistsQry, $pageNr, Artist::LIST_ITEMS);
        
        return $artists;
    }
    
}
