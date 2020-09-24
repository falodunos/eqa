<?php
namespace Base\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author Solomon
 *         @ORM\Entity(repositoryClass="Base\Repository\BaseDbRepository")
 *         @ORM\Table(name = "entity_statuses")
 */
class Status
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
     * @ORM\Column(name="status_name",type="string", length=20, nullable=false)
     */
    protected $statusName;

    /**
     * @ORM\Column(name="status_value",type="string", length=20, nullable=false)
     */
    protected $statusValue;

    /**
     * @ORM\Column(name="status_description", type="string", nullable=true)
     */
    protected $statusDescription;

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
     * @return the $statusValue
     */
    Public function getStatusValue()
    {
        return $this->statusValue;
    }

    /**
     *
     * @param string $statusValue            
     * @return Status
     */
    Public function setStatusValue($statusValue)
    {
        $this->statusValue = $statusValue;
        return $this;
    }

    /**
     *
     * @return the $statusName
     */
    public function getStatusName()
    {
        return $this->statusName;
    }

    /**
     *
     * @return the $statusDescription
     */
    public function getStatusDescription()
    {
        return $this->statusDescription;
    }

    /**
     *
     * @param string $statusName            
     */
    public function setStatusName($statusName)
    {
        $this->statusName = $statusName;
        return $this;
    }

    /**
     *
     * @param string $statusDescription            
     */
    public function setStatusDescription($statusDescription)
    {
        $this->statusDescription = $statusDescription;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *
     * @param integer $createdAt            
     * @return \Base\Entity\AbstractBaseEntity
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
    /*
     * (non-PHPdoc)
     * @see \Base\Entity\Contract\BaseEntityInterface::getEntityClass()
     */
    public function getEntityClass()
    {
        return get_class($this);
    }
}