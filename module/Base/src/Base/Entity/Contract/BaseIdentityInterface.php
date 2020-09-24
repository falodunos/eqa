<?php
namespace Base\Entity\Contract;
use Admin\Entity\Academic\Department;
use Admin\Entity\Academic\Institution;

interface BaseIdentityInterface
{
    /**
     * Get institution.
     *
     * @return string
     */
    public function getInstitution();
    
    /**
     * Get intitution.
     *
     * @return BaseIdentityInterface
    */
    public function setInstitution(Institution $institution);
    
    /**
     * Get department.
     *
     * @return string
     */
    public function getDepartment();
    
    /**
     * Get department.
     *
     * @return BaseIdentityInterface
    */
    public function setDepartment(Department $department);
}