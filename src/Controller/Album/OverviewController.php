<?php
declare(strict_types = 1);

namespace App\Controller\Album;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Album;
use App\Form\Album\FilterType;
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
        // Create the form for filtering the artists
        $form = $this->createForm(FilterType::class, null);
        $form->handleRequest($request);
        
        // Get the page nr
        $pageNr = $request->query->getInt('page', 1);
        
        // Get the non-deleted albums
        $albums = $this->getAlbums($request, $pageNr);
        
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
                'form'        => $form->createView(),
                'albums'      => $albums,
                'startRecord' => $startRecord,
                'endRecord'   => $endRecord
            ]
        );
    }
    
    private function getAlbums(Request $request, int $pageNr): object
    {
        // Get the filter values
        $params = $this->getFilterParams($request);
        
        // Get the albums
        $albumQry = $this->albumSvc->findNonDeletedQuery($params);
        $albums   = $this->paginator->paginate($albumQry, $pageNr, Album::LIST_ITEMS);
        
        return $albums;
    }
    
    /**
     * Get an array with the filter values
     * 
     * @param Request $request
     * 
     * @return array
     */
    private function getFilterParams(Request $request): array
    {
        $params = [];
        
        if (
            !empty($request->query->get('searchValue'))
            && trim($request->query->get('searchValue')) !== ''
        ) {
            $params['searchValue'] = $request->query->get('searchValue');
        }
        
        if (!empty($request->query->get('multipleArtists'))) {
            $params['multipleArtists'] = $request->query->get('multipleArtists');
        }
        
        if (!empty($request->query->get('artist'))) {
            $params['artist'] = $request->query->get('artist');
        }
        
        if (!empty($request->query->get('label'))) {
            $params['label'] = $request->query->get('label');
        }
        
        if (!empty($request->query->get('distributor'))) {
            $params['distributor'] = $request->query->get('distributor');
        }
        
        if (!empty($request->query->get('releaseYear'))) {
            $params['releaseYear'] = $request->query->get('releaseYear');
        }
        
        if (!empty($request->query->get('status'))) {
            $params['status'] = $request->query->get('status');
        }

        return $params;        
    }
}
