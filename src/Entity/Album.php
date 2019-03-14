<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 */
class Album
{
    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_DELETED  = 'deleted';
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $multipleArtists;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artist")
     */
    private $artist;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $alternativeTitle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Label")
     */
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Distributor")
     */
    private $distributor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $releaseYear;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $releaseDate;

    /**
     * @ORM\Column(type="string", length=50)
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
