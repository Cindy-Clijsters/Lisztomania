<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity\Distributor;
use App\Repository\DistributorRepository;

/**
 * Hold distributor functions
 *
 * @author Cindy Clijsters
 */
class DistributorService
{
    private $em;
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator
    ) {
        $this->em         = $entityManager;
        $this->translator = $translator;
    }
    
    /**
     * Get the repository
     * 
     * @return DistributorRepository
     */
    private function getRepository(): DistributorRepository
    {
        return $this->em->getRepository(Distributor::class);
    }
    
    /**
     * Get the query for getting the non-deleted distributors
     * 
     * @return Query
     */
    public function findNonDeletedQuery(): Query
    {
        $distributorRps = $this->getRepository();
        $distributorQry = $distributorRps->findNonDeletedQuery();
        
        return $distributorQry;
    }
    
    /**
     * Get an array with active records
     * 
     * @return array
     */
    public function findActive(): array
    {
        $distributorRps = $this->getRepository();
        $distributors   = $distributorRps->findActive();
        
        return $distributors;  
    }
    
    /**
     * Find a distributor by it's id
     * 
     * @param int $id
     * 
     * @return Distributor|null
     * @throws NotFoundHttpException
     */
    public function findById(int $id): ?Distributor 
    {
        // Find the distributor
        $distributorRps = $this->getRepository();
        $distributor    = $distributorRps->findById($id);
        
        // Display error message when distributor isn't found
        if (!$distributor) {
            throw new NotFoundHttpException(
                $this->translator->trans(
                    'error.noDistributorWithId',
                    ['%id%' => $id],
                    'distributors'
                )
            );
        }
        
        // Return the distributor
        return $distributor;
    }
}
