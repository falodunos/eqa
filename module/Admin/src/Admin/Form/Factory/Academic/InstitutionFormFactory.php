<?php
namespace Admin\Form\Factory\Academic;

use Admin\Form\Academic\InstitutionForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InstitutionFormFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $institutionRepository = $serviceLocator->get('examsqa_admin_institution_repository');
        return new InstitutionForm($institutionRepository);
    }
}