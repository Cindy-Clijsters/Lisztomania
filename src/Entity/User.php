<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BLOCKED  = 'blocked';
    const STATUS_DELETED  = 'deleted';
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;
    
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * 
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $status;
    
    /**
     * Get the id
     * 
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * Get the last name
     * 
     * @return string|null
     */    
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Set the last name
     * 
     * @param string $lastName
     * 
     * @return \self
     */    
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }    
    
    /**
     * Get the first name
     * 
     * @return string|null
     */    
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Set the first name
     * 
     * @param string $firstName
     * 
     * @return \self
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }    

    /**
     * Get the email address
     * 
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the email address
     * 
     * @param string $email
     * 
     * @return \self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * Get the specified roles
     * 
     * @see UserInterface
     */
    public function getRoles(): array
    {        
        return [$this->roles];
    }

    /**
     * Set the roles
     * 
     * @param string $roles
     * 
     * @return \self
     */
    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get the password
     * 
     * @return string|null
     * 
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * Set the password
     * 
     * @param string $password
     * 
     * @return \self
     */  
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the status
     * 
     * @return string|null
     */    
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Set the status
     * 
     * @param string $status
     * 
     * @return \self
     */    
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
    
    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

}