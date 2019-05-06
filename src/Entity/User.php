<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use App\Entity\BaseEntity;
use App\Entity\User;

use DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", hardDelete=true)
 * @Gedmo\Loggable
 * 
 * @UniqueEntity(
 *     "username",
 *     message = "error.uniqueUsername",
 *     groups = {"create"}
 * )
 * @UniqueEntity(
 *     "email",
 *     repositoryMethod = "findNonDeletedForConstraint",
 *     message = "error.uniqueEmail",
 *     groups = {"create", "update", "updateOwnProfile"}
 * )
 */
class User extends BaseEntity implements UserInterface
{
    const STATUS_ACTIVE      = 'active';
    const STATUS_INACTIVE    = 'inactive';
    const STATUS_BLOCKED     = 'blocked';
    const STATUS_UNCONFIRMED = 'unconfirmed';
    
    const VALID_STATUSES = [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_BLOCKED, self::STATUS_UNCONFIRMED];
    
    const ROLE_USER       = 'ROLE_USER';
    const ROLE_ADMIN      = 'ROLE_ADMIN';
    const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';
    
    const VALID_ROLES = [self::ROLE_USER, self::ROLE_ADMIN, self::ROLE_SUPERADMIN];
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * 
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Gedmo\Versioned
     * 
     * @Assert\NotBlank(
     *     message = "error.requiredField",
     *     groups = {"create", "update", "updateOwnProfile"}
     * )
     * @Assert\Type("string", groups = {"create", "update", "updateOwnProfile"})
     * @Assert\Length(
     *     min = 1,
     *     max = 50,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"create", "update", "updateOwnProfile"}
     * )
     * 
     * @var string
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=50)
     * @Gedmo\Versioned
     * 
     * @Assert\NotBlank(
     *     message = "error.requiredField",
     *     groups = {"create", "update", "updateOwnProfile"}
     * )
     * @Assert\Type("string", groups = {"create", "update", "updateOwnProfile"})
     * @Assert\Length(
     *     min = 1,
     *     max = 50,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"create", "update", "updateOwnProfile"}
     * )
     * 
     * @var string
     */
    private $firstName;
    
    /**
     * @ORM\Column(type="string", length=180)
     * @Gedmo\Versioned
     * 
     * @Assert\NotBlank(
     *     message = "error.requiredField",
     *     groups = {"create", "update", "updateOwnProfile"}
     * )
     * @Assert\Type("string", groups = {"create", "update", "updateOwnProfile"})
     * @Assert\Length(
     *     min = 1,
     *     max = 180,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"create", "update", "updateOwnProfile"}
     * )
     * @Assert\Email(
     *     message = "error.validEmailAddress", 
     *     groups = {"create", "update", "updateOwnProfile"}
     * )
     * 
     * @var string
     */
    private $email;
    
    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Gedmo\Versioned
     * 
     * @Assert\NotBlank(
     *     message = "error.requiredField",
     *     groups = {"create"}
     * )
     * @Assert\Type("string", groups = {"create"})
     * @Assert\Length(
     *     min = 6,
     *     max = 100,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"create"}
     * )
     * 
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     * @Gedmo\Versioned
     * 
     * @Assert\NotBlank(message = "error.requiredField", groups = {"create", "update"})
     * @Assert\Type("string", groups = {"create", "update"})
     * @Assert\Length(
     *     min = 1,
     *     max = 255,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"create", "update"}
     * )
     * @Assert\Choice(
     *     choices = Album::VALID_STATUSES,
     *     message = "error.invalidValue",
     *     groups  = {"create", "update"}
     * )
     * 
     * @var string
     */
    private $role;

    /**
     * @Assert\NotBlank(message = "error.requiredField", groups = {"updatePassword", "confirmPassword"})
     * @Assert\Type("string", groups = {"updatePassword", "confirmPassword"})
     * @Assert\Length(
     *     min = 1,
     *     max = 50,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"updatePassword", "confirmPassword"}
     * )
     * @SecurityAssert\UserPassword(
     *     message = "error.incorrectOldPassword",
     *     groups = {"updatePassword", "confirmPassword"}
     * )
     * 
     * @var string (old password)
     */
    private $oldPassword;
    
    /**
     * @Assert\NotBlank(message = "error.requiredField", groups = {"updatePassword", "resetPassword", "confirmRegistration"})
     * @Assert\Type("string", groups = {"updatePassword", "resetPassword", "confirmRegistration"})
     * @Assert\Length(
     *     min = 8,
     *     max = 50,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"updatePassword", "resetPassword", "confirmRegistration"}
     * )
     * @Assert\Regex(
     *     pattern = "/^((?=.*\d)(?=.*[A-Z])(?=.*[a-z])((?=.*\W)|(?=.*\_)).{8,50})/",
     *     match   = true,
     *     message = "error.safePassword",
     *     groups = {"updatePassword", "resetPassword", "confirmRegistration"}
     * )
     * 
     * @var string The unhashed password
     */
    private $plainPassword;
    
    /** 
     * @Assert\NotBlank(message = "error.requiredField", groups = {"updatePassword", "resetPassword", "confirmRegistration"})
     * @Assert\Type("string", groups = {"updatePassword", "resetPassword", "confirmRegistration"})
     * @Assert\EqualTo(
     *     propertyPath = "plainPassword",
     *     message = "error.passwordsUnmatched",
     *     groups = {"updatePassword", "resetPassword", "confirmRegistration"}
     * )
     * 
     * @var string 
     */
    private $confirmPassword;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\Versioned
     * 
     * @var string The hashed password
     */
    private $password;
    
    /**
     * @ORM\Column(length=128, unique=true)
     * 
     * @Gedmo\Slug(fields = {"username"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=20)
     * @Gedmo\Versioned
     * 
     * @Assert\NotBlank(
     *     message = "error.requiredField",
     *     groups = {"update"}
     * )
     * @Assert\Type("string", groups = {"update"})
     * @Assert\Length(
     *     min = 1,
     *     max = 20,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"update"}
     * )
     * @Assert\Choice(
     *     choices = User::VALID_STATUSES,
     *     message = "error.invalidValue",
     *     groups  = {"update"}
     * )
     * 
     * @var string
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
     * Get the full name of the user
     * 
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return $this->firstName . ' ' . $this->lastName;
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
     * Get the user name
     * 
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     * 
     * @return string
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }
    
    /**
     * Set the username
     * 
     * @param string $username
     * 
     * @return \self
     */
    public function setUsername(string $username):self
    {
        $this->username = $username;
        
        return $this;
    }

    /**
     * Get the user role
     * 
     * @see UserInterface
     */
    public function getRole(): ?string
    {        
        return $this->role;
    }

    /**
     * Set the user role
     * 
     * @param string $role
     * 
     * @return \self
     */
    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
    
    /**
     * Get the user role as an array
     * 
     * @see UserInterface
     * 
     * @return array
     */
    public function getRoles(): array
    {
        return [$this->role];
    }

    /**
     * Get the old password
     * 
     * @return string|null
     */
    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }
    
    /**
     * Set the old password
     * 
     * @param string $oldPassword
     * 
     * @return \self
     */
    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;
        
        return $this;
    }
    
    /**
     * Get the plain password
     * 
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }
    
    /**
     * Set the plain password
     * 
     * @param string $plainPassword
     * 
     * @return \self
     */
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        
        return $this;
    }
    
    /**
     * Get the confirmed password
     * 
     * @return string|null
     */
    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }
    
    /**
     * Set the plain password
     * 
     * @param string $confirmPassword
     * 
     * @return \self
     */
    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;
        
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
     * Get the slug
     * 
     * @return string|null
     */
    public function getSlug(): ?string
    {
       return $this->slug; 
    }
    
    /**
     * Set the slug
     * 
     * @param string $slug
     * 
     * @return \self
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        
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
        $this->plainPassword   = null;
        $this->confirmPassword = null;
    }

}
