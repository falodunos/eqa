<?php
namespace Admin\Repository\Academic;

use Base\Repository\BaseDbRepository;
use Admin\Repository\Contract\Academic\DepartmentRepositoryInterface;

class DepartmentRepository extends BaseDbRepository implements DepartmentRepositoryInterface
{
	/* (non-PHPdoc)
     * @see \Admin\Repository\Contract\Academic\DepartmentRepositoryInterface::fetchByIsActive()
     */
    public function fetchByIsActive($sectionIsActive)
    {
        
    }
    
    public function getAdminInstitutionDepartments($serviceLocator) {
        $institution = $serviceLocator->get('zfcuser_auth_service')->getIdentity()->getInstitution();
        return $this->findBy(array('institution'=> $institution));
    }
}