<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Label;

/**
 * @method Label|null find($id, $lockMode = null, $lockVersion = null)
 * @method Label|null findOneBy(array $criteria, array $orderBy = null)
 * @method Label[]    findAll()
 * @method Label[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LabelRepository extends ServiceEntityRepository
{
    /**
     * Constructor function
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Label::class);
    }

    /**
     * Get the non-deleted labels
     * 
     * @return Query
     */
    public function findNonDeletedQuery(string $searchValue = '', string $status = ''): Query
    {
        $query = $this->createQueryBuilder('l');
        
        if ($searchValue !== '') {
            $query = $query->andWhere('l.name LIKE :searchValue')
                           ->setParameter('searchValue', '%' . addcslashes($searchValue, '%_') . '%');
        }
        
        if ($status !== '') {
            $query = $query->andWhere('l.status = :searchStatus')
                           ->setParameter('searchStatus', $status);
        }
            
        $query = $query->orderBy('l.name', 'ASC')
                       ->getQuery();
        
        return $query;
    }
    
    /**
     * Check if the name if unique (without deleted labels)
     * 
     * @param array $criteria
     * 
     * @return arrat
     */
    public function findNonDeletedForConstraint(array $criteria): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.name = :name')
            ->andWhere('l.deletedAt IS NULL')
            ->setParameter('name', $criteria['name'])
            ->getQuery()
            ->getResult();
    }
    
    /**
     * Get an array with the active labels
     * 
     * @return array
     */
    public function findActive(): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.status = :activeStatus')
            ->setParameter('activeStatus', Label::STATUS_ACTIVE)
            ->orderBy('l.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * Find a label by it's slug
     * 
     * @param string $slug
     * 
     * @return Label|null
     */
    public function findBySlug(string $slug): ?Label
    {
        return $this->createQueryBuilder('l') 
            ->andWhere('l.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
