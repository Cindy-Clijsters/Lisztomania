<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtistRepository")
 * 
 * @UniqueEntity(
 *     "name",
 *     repositoryMethod = "findNonDeletedForConstraint",
 *     message = "error.uniqueName",
 *     groups = {"create"}
 * )
 */
class Artist
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_DELETED = 'deleted';
    
    const LIST_ITEMS = 10;
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * 
     * @Assert\NotBlank(
     *     message = "error.requiredField",
     *     groups  = "create",
     * )
     * @Assert\Type("string", groups = {"create"})
     * @Assert\Length(
     *     min = 1,
     *     max = 100,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"create"}
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     * 
     * @Assert\NotBlank(
     *     message = "error.requiredField",
     *     groups  = "create",
     * )
     * @Assert\Type("string", groups = {"create"})
     * @Assert\Length(
     *     min = 1,
     *     max = 100,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"create"}
     * )
     */
    private $sortName;

    /**
     * @ORM\Column(type="string", length=20)
     * 
     * @Assert\NotBlank(message = "error.requiredField", groups = {"create"})
     * @Assert\Type("string", groups = {"create"})
     * @Assert\Length(
     *     min = 1,
     *     max = 20,
     *     minMessage = "error.minCharacters",
     *     maxMessage = "error.maxCharacters",
     *     groups = {"create"}
     * )
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
