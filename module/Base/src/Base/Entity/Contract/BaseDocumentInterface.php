<?php
namespace Base\Entity\Contract;

use Admin\Entity\Academic\Department;
use Admin\Entity\Academic\Institution;

interface BaseDocumentInterface
{

    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Get name
     *
     * @return string
     */
    public function getDocumentName();
    
    /**
     * Set documentName.
     *
     * @param string $documentName
     * @return BaseDocumentInterface
    */
    public function setDocumentName($documentName);
    /**
     * Set description.
     *
     * @param string $documentDescription            
     * @return BaseDocumentInterface
     */
    public function setDocumentDescription($documentDescription);
    
    /**
     * Get documentDescription
     *
     * @return string
     */
    public function getDocumentDescription();
    
    /**
     * Get documentPath
     *
     * @return string
     */
    public function getDocumentPath();

    /**
     * Set documentPath.
     *
     * @param string $documentPath            
     * @return BaseDocumentInterface
     */
    public function setDocumentPath($documentPath);

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
     * @return BaseDocumentInterface
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
     * @return BaseDocumentInterface
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
     * @return BaseDocumentInterface
     */
    public function setIsActive($isActive);

    /**
     * Get Institution.
     * @return Institution
     */
    public function getInstitution();

    /**
     * Set isActive.
     *
     * @param SmallIntType $isActive            
     * @return BaseDocumentInterface
     */
    public function setInstitution(Institution $institution);

    /**
     * Get Department.
     * @return Department
     */
    public function getDepartment();
    
    /**
     * Set department.
     *
     * @param SmallIntType $isActive
     * @return BaseDocumentInterface
     */
    public function setDepartment(Department $department);
}