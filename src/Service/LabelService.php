<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity\Label;
use App\Repository\LabelRepository;

/**
 * Hold label functions
 *
 * @author Cindy Clijsters
 */
class LabelService
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
     * @return LabelRepository
     */
    public function getRepository(): LabelRepository
    {
        return $this->em->getRepository(Label::class);
    }  
    
    /**
     * Get a query to get the non-deleted labels
     * 
     * @return Query
     */
    public function findNonDeletedQuery(): Query
    {
        $labelRps = $this->getRepository();
        $labelQry = $labelRps->findNonDeletedQuery();
        
        return $labelQry;
    }
    
    /**
     * Get an array with active labels
     * 
     * @return array
     */
    public function findActive(): array
    {
        $labelRps = $this->getRepository();
        $labels    = $labelRps->findActive();
        
        return $labels;
    }
    
    /**
     * Find a label by it's id
     * 
     * @param int $id
     * 
     * @return Label|null
     * @throws NotFoundHttpException
     */
    public function findById(int $id): ?Label
    {
        $labelRps = $this->getRepository();
        $label    = $labelRps->findById($id);
        
        if (!$label) {
            throw new NotFoundHttpException(
                $this->translator->trans(
                    'error.noLabelWithId',
                    ['%id%' => $id],
                    'labels'
                )
            );
        }
        
        return $label;
    }
}
