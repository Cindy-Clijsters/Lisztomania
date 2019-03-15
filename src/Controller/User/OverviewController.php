<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\User;
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
     * Show an overview with the users
     * 
     * @Route({
     *  "nl" : "/beheer/gebruikers/overzicht",
     *  "en" : "/admin/users/overview"
     * }, name="rtAdminUserOverview")
     * 
     * @param Request $request
     * 
     * @return Response
     */
    public function overview(Request $request):Response
    {
        // Get the page nr
        $pageNr = $request->query->getInt('page', 1);
        
        // Get the non-deleted users
        $userRps  = $this->getDoctrine()->getRepository(User::class);
        $usersQry = $userRps->findNonDeletedQuery();
        
        $users = $this->paginator->paginate($usersQry, $pageNr, User::LIST_ITEMS);
        
        // Get the start- and end record of the shown items
        list($startRecord, $endRecord) = $this->listSvc->getStartEndRecord(
            $pageNr,
            User::LIST_ITEMS,
            $users->getTotalItemCount()
        );
        
        // Display the view
        return $this->render(
            'user/overview.html.twig',
            [
                'users'       => $users,
                'startRecord' => $startRecord,
                'endRecord'   => $endRecord
            ]
        );
    }
    
}
