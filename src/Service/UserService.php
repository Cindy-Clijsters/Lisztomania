<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\EncryptionService;

/**
 * Hold user functions
 *
 * @author Cindy Clijsters
 */
class UserService
{
    private $em;
    private $translator;
    private $encoder;
    private $encryptionSvc;
    
    /**
     * Consgit tructor function
     * 
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     * @param UserPasswordEncoderInterface $encoder
     * @param EncryptionService $encryptionService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator,
        UserPasswordEncoderInterface $encoder,
        EncryptionService $encryptionService
    ) {
        $this->em            = $entityManager;
        $this->translator    = $translator;
        $this->encoder       = $encoder;
        $this->encryptionSvc = $encryptionService;
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
    
    /**
     * Find an user by it's username
     * 
     * @param string $searchValue
     * 
     * @return User|null
     */
    public function findByUsername(string $searchValue): ?User
    {
        $userRps = $this->getRepository();
        $user    = $userRps->findByUsername($searchValue);
        
        return $user;
    }
    
    /**
     * Find a user by it's identifier
     * 
     * @param string $identifier
     * @param string $action
     * 
     * @return User|null
     * @throws NotFoundHttpException
     */
    public function findByIdentifier(string $identifier, string $action): ?User
    {
        // Get the username
        $username = $this->decryptIdentifier($identifier, $action);
        
        // Get the user
        $user = null;
        if ($username !== '') {
            $user = $this->findByUsername($username);
        }
        
        // Throw error message when user isn't found
        if (!$user) {
            throw new NotFoundHttpException(
                $this->translator->trans(
                    'error.invalidIdentifier'
                )
            );
        }
        
        return $user;
    }
    
    /**
     * Find an admin by it's username or e-mail address
     * 
     * @param string $searchValue
     * 
     * @return User|null
     */
    public function findAdminByUsernameOrEmail(string $searchValue)
    {
        $userRps = $this->getRepository();
        $user    = $userRps->findAdminByUsernameOrEmail($searchValue);
        
        return $user;
    }    
    
    /**
     * Find a administrator by it's identifier
     * 
     * @param string $identifier
     * @param string $action
     * 
     * @return User|null
     * @throws NotFoundHttpException
     */
    public function findAdminByIdentifier(string $identifier, string $action): ?User
    {
        $userName = $this->decryptIdentifier($identifier, $action);
        
        $user = null;
        if ($userName !== '') {
            $user = $this->findAdminByUsernameOrEmail($userName);
        }
        
        if (!$user) {
            throw new NotFoundHttpException(
                $this->translator->trans(
                    'error.invalidIdentifier'
                )
            );
        }
        
        return $user;
    }
    
    /**
     * Decrypt the identifier
     * 
     * @param string $identifier
     * @param string $action
     * 
     * @return string
     */
    public function decryptIdentifier(string $identifier, string $action): string
    {
        return $this->encryptionSvc->decrypt(
            $identifier,
            $action
        );
    }
    
    /**
     * Save the user in the database
     * 
     * @param User $user
     * 
     * @return void
     */
    public function saveToDb(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
    
    /**
     * Get the hashed password
     * 
     * @param User $user
     * 
     * @return string
     */
    public function getHashedPassword(User $user): string
    {
        $hashedPassword = $this->encoder->encodePassword(
            $user,
            $user->getPlainPassword()
        );
        
        return $hashedPassword;
    }
    
    /**
     * Check if the password is valid
     * 
     * @param User $user
     * @param string $oldPassword
     * 
     * @return bool
     */
    public function checkValidPassword(User $user, string $oldPassword): bool
    {
        return $this->encoder->isPasswordValid($user, $oldPassword);
    }
    
}
