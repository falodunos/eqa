<?php
namespace Base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Base\Entity\Contract\BaseEntityInterface;

/*
 * @ORM\MappedSuperclass
 */
abstract class AbstractBaseEntity implements BaseEntityInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=false)
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="string", name="is_active", length=1, nullable=false, options={"default":"1"})
     */
    protected $isActive;

    /**
     *
     * @see \Base\Entity\Contract\BaseEntityInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *
     * @param \DateTime $createdAt            
     * @return \Base\Entity\AbstractBaseEntity
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     *
     * @param \DateTime $updatedAt            
     * @return \Base\Entity\AbstractBaseEntity
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     *
     * @return the $isActive
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     *
     * @param field_type $isActive            
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }
    /* (non-PHPdoc)
     * @see \Base\Entity\Contract\BaseEntityInterface::getEntityClass()
     */
    
    public function getEntityClass()
    {
        return get_class($this);
    }
}