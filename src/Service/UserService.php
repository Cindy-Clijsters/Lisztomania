<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity\User;

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
     * @return object
     */
    public function getRepository()
    {
        return $this->em->getRepository(User::class);
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
