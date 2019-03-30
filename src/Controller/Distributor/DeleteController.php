<?php
declare(strict_types = 1);

namespace App\Controller\Distributor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
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
    private $em;
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param DistributorService $distributorService
     * @param AlbumService $albumService
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     */
    public function __construct(
        DistributorService $distributorService,
        AlbumService $albumService,
        EntityManagerInterface $em,
        TranslatorInterface $translator
    ) {
        $this->distributorSvc = $distributorService;
        $this->albumSvc       = $albumService;
        $this->em             = $em;
        $this->translator     = $translator;
    }
    
    /**
     * Delete a distributor
     * 
     * @Route({
     *  "nl" : "/beheer/distributeurs/verwijderen/{id}",
     *  "en" : "/admin/distributors/delete/{id}"
     * }, name="rtAdminDistributorDelete")
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function delete(int $id): Response
    {
        // Get the information of the distributor
        $distributor = $this->distributorSvc->findById($id);
        
        // Check if the distributor is linked to an album
        $albumCount = $this->albumSvc->countAlbumsByDistributor($distributor);
        
        if ($albumCount === 0) {
            
            // Set the status of the distributor to deleted
            $distributor->setStatus(Distributor::STATUS_DELETED);
            
            // Save the distributor
            $this->em->persist($distributor);
            $this->em->flush();
            
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
            'distributor/delete.html.twig'
        );          
    }
}
