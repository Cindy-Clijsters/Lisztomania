<?php
declare(strict_types = 1);

namespace App\Controller\Distributor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\Distributor;
use App\Service\DistributorService;
use App\Service\AlbumService;

/**
 * Delete a distributor
 *
 * @author Cindy Clijsters
 */
class DeleteController extends AbstractController
{
    private $distributorSvc;
    private $albumSvc;
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param DistributorService $distributorService
     * @param AlbumService $albumService
     * @param TranslatorInterface $translator
     */
    public function __construct(
        DistributorService $distributorService,
        AlbumService $albumService,
        TranslatorInterface $translator
    ) {
        $this->distributorSvc = $distributorService;
        $this->albumSvc       = $albumService;
        $this->translator     = $translator;
    }
    
    /**
     * Delete a distributor
     * 
     * @Route({
     *  "nl" : "/beheer/distributeurs/verwijderen/{slug}",
     *  "en" : "/admin/distributors/delete/{slug}"
     * }, name="rtAdminDistributorDelete")
     * 
     * @param string $slug
     * 
     * @return Response
     */
    public function delete(string $slug): Response
    {
        // Get the information of the distributor
        $distributor = $this->distributorSvc->findBySlug($slug);
        
        // Check if the distributor is linked to an album
        $albumCount = $this->albumSvc->countAlbumsByDistributor($distributor);
        
        if ($albumCount === 0) {
            
            // Save the distributor
            $this->distributorSvc->removeFromDb($distributor);
            
            // Redirect to the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.deletedSuccessfully',
                    [
                        '%name%' => $distributor->getName()
                    ],
                    'distributors'
                )
            );
            
            return $this->redirectToRoute('rtAdminDistributorOverview');
        }
        
        // Display the view
        return $this->render(
            'distributor/delete.html.twig',
            [
                'distributor' => $distributor
            ]
        );          
    }
}
