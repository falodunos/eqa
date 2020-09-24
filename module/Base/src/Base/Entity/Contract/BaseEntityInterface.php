<?php
namespace Base\Entity\Contract;

interface BaseEntityInterface
{

    /**
     * Get id.
     *
     * @return string
     */
    public function getId();

    /**
     * Get createdAt.
     *
     * @return datetime
     */
    public function getCreatedAt();

    /**
     * Set createdAt.
     *
     * @param datetime $createdAt            
     * @return BaseEntityInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updatedAt.
     *
     * @return datetime
     */
    public function getUpdatedAt();

    /**
     * Set createdAt.
     *
     * @param datetime $updatedAt            
     * @return BaseEntityInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get isActive.
     *
     * @return string
     */
    public function getIsActive();
    /**
     * Set isActive.
     *
     * @param SmallIntType $isActive
     * @return BaseEntityInterface
     */
    public function setIsActive($isActive);
    
    public function getEntityClass();
}