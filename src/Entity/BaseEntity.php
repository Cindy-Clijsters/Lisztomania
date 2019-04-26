<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

use App\Entity\User;

use DateTime;

/**
 * Base class for each entity
 *
 * @author Cindy Clijsters
 */
class BaseEntity
{
    const LIST_ITEMS = 10;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     * 
     * @var DateTime|null
     */
    protected $created;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true)
     * @Gedmo\Blameable(on="create")
     * 
     * @var User|null
     */
    protected $createdBy;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     * 
     * @var DateTime|null
     */
    protected $updated;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", nullable=true)
     * @Gedmo\Blameable(on="update")
     * 
     * @var User|null
     */
    protected $updatedBy;    
    
    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     * 
     * @var DateTime 
     */
    protected $deletedAt;
    
    /**
     * Get the creation date
     * 
     * @return DateTime|null
     */
    public function getCreated(): ?DateTime
    {
        return $this->created;
    }
    
    /**
     * Get the user who created the record
     * 
     * @return User|null
     */
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }
    
    /**
     * Get the date of the last update
     * 
     * @return DateTime|null
     */
    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }
    
    /**
     * Get the user who updated the record the last time
     * 
     * @return User|null
     */
    public function getUpdatedBy(): ?User
    {
        return $this->createdBy;
    }   
    
    /**
     * Get the date of deletion
     *
     * @return DateTime|null
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }
    
    /**
     * Set the status of deletion
     * 
     * @param DateTime $deletedAt
     * 
     * @return \self
     */    
    public function setDeletedAt(DateTime $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        
        return $this;
    }    
}
