<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\BaseEntity;
use App\Entity\User;
use App\Validator\Constraints\Album as AlbumAssert;

use DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", hardDelete=true)
 * @Gedmo\Loggable
 * 
 * @AlbumAssert\SelectAlbumArtist(groups = {"create", "update"})
 */
class Album extends BaseEntity
{
    const STATUS_ACTIVE   = 'active';
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
     * @ORM\Column(type="boolean")
     * @Gedmo\Versioned
     * 
     * @var bool
     */
    private $multipleArtists;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artist")
     * @Gedmo\Versioned
     * 
     * @Assert\Valid
     * 
     * @var Artist
     */
    private $artist;

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
    private $title;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Gedmo\Versioned
     * 
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
    private $alternativeTitle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Label")
     * @Gedmo\Versioned
     * 
     * @Assert\Valid(groups = {"create", "update"})
     * 
     * @var Label
     */
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Distributor")
     * @Gedmo\Versioned
     * 
     * @Assert\Valid(groups = {"create", "update"})
     * 
     * @var Distributor;
     */
    private $distributor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned
     * 
     * @Assert\Type("integer", groups = {"create", "update"})
     * @Assert\Length(
     *     min = 4,
     *     max = 4,
     *     exactMessage = "error.exactCharacters",
     *     groups = {"create", "update"}
     * )
     * 
     * @var int
     */
    private $releaseYear;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Versioned
     * 
     * @Assert\Date(groups = {"create", "update"})
     * 
     * @var DateTime
     */
    private $releaseDate;

    /**
     * @ORM\Column(length=128, unique=true)
     * 
     * @Gedmo\Slug(fields={"title"})
     * 
     * @var string
     */
    private $slug;
    
    /**
     * @ORM\Column(type="string", length=50)
     * @Gedmo\Versioned
     * 
     * @Assert\NotBlank(
     *     message = "error.requiredField",
     *     groups = {"create", "update"}
     * )
     * @Assert\Type("string", groups = {"create", "update"})
     * @Assert\Length(
     *     min = 1,
     *     max = 50,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"create", "update"}
     * )
     * @Assert\Choice(
     *     choices = Album::VALID_STATUSES,
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
     * Get the multiple artists value
     * 
     * @return bool|null
     */
    public function getMultipleArtists(): ?bool
    {
        return $this->multipleArtists;
    }

    /**
     * Set the multiple artists values
     * 
     * @param bool $multipleArtists
     * 
     * @return \self
     */
    public function setMultipleArtists(bool $multipleArtists): self
    {
        $this->multipleArtists = $multipleArtists;

        return $this;
    }

    /**
     * Get the artist
     * 
     * @return \App\Entity\Artist|null
     */
    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    /**
     * Set the artist
     * 
     * @param \App\Entity\Artist|null $artist
     * 
     * @return \self
     */
    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }
    
    /**
     * Get the name of the artist
     * 
     * @return string|null
     */
    public function getArtistSortName(): ?string
    {
        $artistName = '';
        
        if ($this->artist !== null) {
            $artistName = $this->artist->getSortName();
        }
        
        return $artistName;
    }

    /**
     * Get the title
     * 
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the title
     * 
     * @param string $title
     * 
     * @return \self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the alternative title
     * 
     * @return string|null
     */
    public function getAlternativeTitle(): ?string
    {
        return $this->alternativeTitle;
    }

    /**
     * Set the alternative title
     * 
     * @param string|null $alternativeTitle
     * 
     * @return \self
     */
    public function setAlternativeTitle(?string $alternativeTitle): self
    {
        $this->alternativeTitle = $alternativeTitle;

        return $this;
    }

    /**
     * Get the label
     * 
     * @return \App\Entity\Label|null
     */
    public function getLabel(): ?Label
    {
        return $this->label;
    }

    /**
     * Set the label
     * 
     * @param \App\Entity\Label|null $label
     * 
     * @return \self
     */
    public function setLabel(?Label $label): self
    {
        $this->label = $label;

        return $this;
    }
    
    /**
     * Get the name of the label
     * 
     * @return string
     */
    public function getLabelName(): string
    {
        $labelName = '';
        
        if ($this->label !== null) {
            $labelName = $this->label->getName();
        }
        
        return $labelName;
    }

    /**
     * Get the distributor
     * 
     * @return \App\Entity\Distributor|null
     */
    public function getDistributor(): ?Distributor
    {
        return $this->distributor;
    }

    /**
     * Set the distributor
     * 
     * @param \App\Entity\Distributor|null $distributor
     * 
     * @return \self
     */
    public function setDistributor(?Distributor $distributor): self
    {
        $this->distributor = $distributor;

        return $this;
    }
    
    /**
     * Get the name of the distributor
     * 
     * @return string
     */
    public function getDistributorName(): string
    {
        $distributorName = '';
        
        if ($this->distributor !== null) {
            $distributorName = $this->distributor->getName();
        }
        
        return $distributorName;
    }    

    /**
     * Get the release year
     * 
     * @return int|null
     */
    public function getReleaseYear(): ?int
    {
        return $this->releaseYear;
    }

    /**
     * Set the release year
     * 
     * @param int|null $releaseYear
     * 
     * @return \self
     */
    public function setReleaseYear(?int $releaseYear): self
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    /**
     * Get the release date
     * 
     * @return \DateTimeInterface|null
     */
    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    /**
     * Set the release date
     * 
     * @param \DateTimeInterface|null $releaseDate
     * 
     * @return \self
     */
    public function setReleaseDate(?\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

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
