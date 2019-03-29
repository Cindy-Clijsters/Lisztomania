<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

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
    
    /**
     * Constructor function
     * 
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
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
}
