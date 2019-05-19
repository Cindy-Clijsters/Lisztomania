<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

use App\Entity\BaseEntity;

use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtistRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", hardDelete=true)
 * @Gedmo\Loggable
 * @Vich\Uploadable
 * 
 * @UniqueEntity(
 *     "name",
 *     repositoryMethod = "findNonDeletedForConstraint",
 *     message = "error.uniqueName",
 *     groups = {"create", "update"}
 * )
 */
class Artist extends BaseEntity
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    const VALID_STATUSES = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * 
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Gedmo\Versioned
     * 
     * @Assert\NotBlank(
     *     message = "error.requiredField",
     *     groups  = {"create", "update"}
     * )
     * @Assert\Type("string", groups = {"create", "update"})
     * @Assert\Length(
     *     min = 1,
     *     max = 100,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"create", "update"}
     * )
     * 
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @Gedmo\Versioned
     * 
     * @Assert\NotBlank(
     *     message = "error.requiredField",
     *     groups  = {"create", "update"},
     * )
     * @Assert\Type("string", groups = {"create", "update"})
     * @Assert\Length(
     *     min = 1,
     *     max = 100,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"create", "update"}
     * )
     * 
     * @var string
     */
    private $sortName;
    
    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Gedmo\Translatable
     * 
     * @var text 
     */
    private $description;           
    
    /**
     * @Gedmo\Locale
     * 
     * @var string 
     */
    private $locale;
    
    /**
     * @ORM\Column(type="string", nullable = true, length=2)
     * @Gedmo\Versioned
     * 
     * @Assert\Length(
     *     min = 2,
     *     max = 2,
     *     exactMessage = "error.exactCharacters",
     *     groups = {"create", "update"}
     * )
     * 
     * @var string 
     */
    private $country;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     * 
     * @var string 
     */
    private $image;
    
    /**
     * @Vich\UploadableField(mapping="artists_images", fileNameProperty="image")
     * 
     * @Assert\Image(
     *  maxSize = "200k",
     *  minWidth = 320,
     *  maxWidth = 960,
     *  minHeight = 320,
     *  maxHeight = 960,
     *  mimeTypes = {"image/jpeg", "image/png"}
     * )
     * 
     * @var File 
     */
    private $imageFile;
    
    /**
     * @ORM\Column(length = 128, unique = true)
     * 
     * @Gedmo\Slug(fields = {"name"})
     * 
     * @var string
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=20)
     * @Gedmo\Versioned
     * 
     * @Assert\NotBlank(
     *     message = "error.requiredField",
     *     groups = {"create", "update"}
     * )
     * @Assert\Type("string", groups = {"create", "update"})
     * @Assert\Length(
     *     min = 1,
     *     max = 20,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"create", "update"}
     * )
     * @Assert\Choice(
     *     choices = Artist::VALID_STATUSES,
     *     message = "error.invalidValue",
     *     groups = {"create", "update"}
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
     * Get the name
     * 
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the name
     * 
     * @param string $name
     * 
     * @return \self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the sorting name
     * 
     * @return string|null
     */
    public function getSortName(): ?string
    {
        return $this->sortName;
    }

    /**
     * Set the sorting name
     * 
     * @param string $sortName
     * 
     * @return \self
     */
    public function setSortName(string $sortName): self
    {
        $this->sortName = $sortName;

        return $this;
    }
    
    /**
     * Get the description
     * 
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    /**
     * Set the description
     * 
     * @param string $description
     * 
     * @return \self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        
        return $this;
    }
    
    /**
     * Get the country
     * 
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }
    
    /**
     * Set the country
     * 
     * @param string $country
     * 
     * @return \self
     */
    public function setCountry(?string $country): self
    {
        $this->country = $country;
        
        return $this;
    }
    
    /**
     * Get the image
     * 
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }
    
    /**
     * Set the image
     * 
     * @param string|null $image
     * 
     * @return \self
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;
        
        return $this;
    }
    
    /**
     * Get the image file
     * 
     * @return File|null
     */
    public function getImageFile(): ?File 
    {
        return $this->imageFile;
    }
    
    /**
     * Set the image file
     * 
     * @param File|null $image
     * 
     * @return \self
     */
    public function setImageFile(?File $image): self
    {
        $this->imageFile = $image;
        
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
        
        return $this;
    }
    
    /**
     * Set the locale
     * 
     * @param string $locale
     * 
     * @return \self
     */
    public function setTranslatableLocale(string $locale): self
    {
        $this->locale = $locale;
        
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
}
