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
     * Find a label by it's slug
     * 
     * @param string $slug
     * 
     * @return Label|null
     * @throws NotFoundHttpException
     */
    public function findBySlug(string $slug): ?Label
    {
        $labelRps = $this->getRepository();
        $label    = $labelRps->findBySlug($slug);
        
        if (!$label) {
            throw new NotFoundHttpException(
                $this->translator->trans(
                    'error.noLabelWithSlug',
                    ['%slug%' => $slug],
                    'labels'
                )
            );
        }
        
        return $label;
    }
    
    /**
     * Save the label into the database
     * 
     * @param Label $label
     * 
     * @return void
     */
    public function saveToDb(Label $label): void
    {
        $this->em->persist($label);
        $this->em->flush();
    }
    
    /**
     * Remove the label from the db
     * 
     * @param Label $label
     * 
     * @return void
     */
    public function removeFromDb(Label $label): void
    {
        $label->setSlug($label->getSlug() . '_softdeleted_' . $label->getId());
        $this->em->persist($label);
        $this->em->flush();
        
        $this->em->remove($label);
        $this->em->flush();
    }
}
