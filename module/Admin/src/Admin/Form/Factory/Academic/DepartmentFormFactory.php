<?php
namespace Admin\Form\Factory\Academic;

use Admin\Form\Academic\DepartmentForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DepartmentFormFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $departmentRepository = $serviceLocator->get('examsqa_admin_department_repository');
        $institutionRepository = $serviceLocator->get('examsqa_admin_institution_repository');
        return new DepartmentForm($departmentRepository, $institutionRepository);
    }
}