<?php
declare(strict_types = 1);

namespace App\Controller\Album;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Album;
use App\Service\AlbumService;
use App\Service\ListService;

/**
 * Show an overview of the albums
 *
 * @author Cindy Clijsters
 */
class OverviewController extends AbstractController
{
    private $paginator;
    private $albumSvc;
    private $listSvc;
    
    /**
     * Constructor function
     * 
     * @param PaginatorInterface $paginator
     * @param AlbumService $albumService
     * @param ListService $listService
     */
    public function __construct(
        PaginatorInterface $paginator,
        AlbumService $albumService,
        ListService $listService
    ) {
        $this->paginator = $paginator;
        $this->albumSvc  = $albumService;
        $this->listSvc   = $listService;
    }
    
    /**
     * Show an overview of the albums
     * 
     * @Route({
     *  "nl" : "/beheer/albums/overzicht",
     *  "en" : "/admin/albums/overview"
     * }, name="rtAdminAlbumOverview")
     * 
     * @param Request $request
     * 
     * @return Response
     */
    public function overview(Request $request):Response
    {
        // Get the page nr
        $pageNr = $request->query->getInt('page', 1);
        
        // Get the non-deleted albums
        $albumQry = $this->albumSvc->findNonDeletedQuery();
        $albums   = $this->paginator->paginate($albumQry, $pageNr, Album::LIST_ITEMS);
        
        // Get the start- and endrecord for the shown items
        list($startRecord, $endRecord) = $this->listSvc->getStartEndRecord(
            $pageNr,
            Album::LIST_ITEMS,
            $albums->getTotalItemCount()
        );
                
        // Display the view
        return $this->render(
            'album/overview.html.twig',
            [
                'albums'      => $albums,
                'startRecord' => $startRecord,
                'endRecord'   => $endRecord
            ]
        );
    }
}
