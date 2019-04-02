<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity\User;
use App\Repository\UserRepository;

/**
 * Hold user functions
 *
 * @author Cindy Clijsters
 */
class UserService
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
     * @return UserRepository
     */
    public function getRepository(): UserRepository
    {
        return $this->em->getRepository(User::class);
    }
    
    /**
     * Get the query for finding the non-deleted users
     * 
     * @return Query
     */
    public function findNonDeletedQuery(): Query
    {
        $userRps = $this->getRepository();
        $userQry = $userRps->findNonDeletedQuery();
        
        return $userQry;
    }
    
    /**
     * Find a user by it's id
     * 
     * @param int $id
     * 
     * @return User|null
     * @throws NotFoundHttpException
     */
    public function findById(int $id): ?User 
    {
        $userRps = $this->getRepository();
        $user    = $userRps->findById($id);
        
        if (!$user) {
            throw new NotFoundHttpException(
                $this->translator->trans(
                    'error.noUserWithId',
                    ['%id%' => $id],
                    'users'
                )
            );
        }
        
        return $user;
    }
    
}
