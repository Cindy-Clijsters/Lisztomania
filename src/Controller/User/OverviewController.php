<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;

use App\Entity\User;
use App\Form\User\FilterType;
use App\Service\UserService;
use App\Service\ListService;

/**
 * Show an overview of the users
 *
 * @author Cindy Clijsters
 */
class OverviewController extends AbstractController
{
    private $paginator;
    private $userSvc;
    private $listSvc;
    
    /**
     * Constructor function
     * 
     * @param PaginatorInterface $paginator
     * @param UserService $userService
     * @param ListService $listService
     */
    public function __construct(
        PaginatorInterface $paginator,
        UserService $userService,
        ListService $listService
    ) {
        $this->paginator = $paginator;
        $this->userSvc   = $userService;
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
        // Create the form for filtering users
        $form = $this->createForm(FilterType::class, null);
        $form->handleRequest($request);
        
        // Get the page nr
        $pageNr = $request->query->getInt('page', 1);
        
        // Get the non-deleted users
        $users = $this->getUsers($request, $pageNr);
        
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
                'form'        => $form->createView(),
                'users'       => $users,
                'startRecord' => $startRecord,
                'endRecord'   => $endRecord
            ]
        );
    }
    
    /**
     * Get the users
     * 
     * @param Request $request
     * @param int $pageNr
     * 
     * @return object
     */
    private function getUsers(Request $request, int $pageNr)
    {
        // Get the filter values
        $searchValue = $request->query->get('searchValue', '');
        $role        = $request->query->get('role', '');
        $status      = $request->query->get('status', '');
        
        // Get the users
        $usersQry = $this->userSvc->findNonDeletedQuery($searchValue, $role, $status);
        $users    = $this->paginator->paginate(
            $usersQry,
            $pageNr,
            User::LIST_ITEMS
        );        
        
        return $users;
    }
    

}
