<?php
namespace Admin\Entity\Contract\Academic;

use Base\Entity\Contract\BaseEntityInterface;
use Admin\Entity\Academic\Institution;

interface DepartmentInterface extends BaseEntityInterface
{

    /**
     * Get deptName.
     *
     * @return string
     */
    public function getDeptName();

    /**
     * Set deptName.
     *
     * @param string $deptName       
     * @return DepartmentInterface
     */
    public function setDeptName($deptName);
    
    /**
     * Get Institution.
     *
     * @return string
     */
    public function getInstitution();
    
    /**
     * Set Institution.
     *
     * @param string $institution
     * @return InstitutionInterface
    */
    public function setInstitution(Institution $institution = null);
    

    /**
     * Get deptAcronym
     *
     * @return string
     */
    public function getDeptAcronym();
    
    /**
     * Set deptAcronym.
     *
     * @param string $deptAcronym
     * @return DepartmentInterface
    */
    public function setDeptAcronym($deptAcronym);
    
    
    /**
     * Get deptDesctiption.
     *
     * @return string
     */
    public function getDeptDescription();
    
    /**
     * Set deptDescription.
     *
     * @param string $deptDescription
     * @return DepartmentInterface
     */
    public function setDeptDescription($deptDescription);
    
    /**
     * Set contactPerson.
     *
     * @param string $contactPerson
     * @return DepartmentInterface
    */
    public function setContactPerson($contactPerson);
    
    /**
     * Get contactPerson.
     *
     * @return string
     */
    public function getContactPerson();
    
    /**
     * Set deptPhone.
     *
     * @param string $deptPhone
     * @return DepartmentInterface
     */
    public function setDeptPhone($deptPhone);
    
    /**
     * Get deptPhone.
     *
     * @return string
    */
    public function getDeptPhone();
    
    /**
     * Set deptEmail.
     *
     * @param string $deptEmail
     * @return DepartmentInterface
     */
    public function setDeptEmail($deptEmail);
    
    /**
     * Get deptEmail.
     *
     * @return string
    */
    public function getDeptEmail();

    /**
     * Get dateEstablished.
     *
     * @return string
     */
    public function getDateEstablished();
    
    /**
     * Set dateEstablished.
     *
     * @param string $dateEstablished
     * @return ExamInterface
    */
    public function setDateEstablished($dateEstablished);
}