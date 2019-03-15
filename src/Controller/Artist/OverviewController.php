<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Artist;

/**
 * Show an overview of the artists
 *
 * @author Cindy Clijsters
 */
class OverviewController extends AbstractController
{
    private $paginator;
    
    /**
     * Constructor function
     * 
     * @param PaginatorInterface $paginator
     */
    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
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
        list($startRecord, $endRecord) = $this->getStartEndRecord(
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
    
    /**
     * Calculate the number of the start- and end record
     * 
     * @param int $pageNr
     * @param int $itemsByPage
     * @param int $totalCount
     * 
     * @return array
     */
    private function getStartEndRecord(int $pageNr, int $itemsByPage, int $totalCount): array
    {
        $startRecord = ($pageNr - 1) * $itemsByPage + 1;
        $endRecord   = $startRecord + $itemsByPage - 1;
        
        if ($endRecord > $totalCount) {
            $endRecord = $totalCount;
        }
        
        return [$startRecord, $endRecord];
    }    
}
