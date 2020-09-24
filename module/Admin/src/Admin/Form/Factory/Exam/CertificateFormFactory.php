<?php
namespace Admin\Form\Factory\Exam;

use Admin\Form\Exam\CertificateForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CertificateFormFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $doctrine_orm_object_manager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        return new CertificateForm($doctrine_orm_object_manager);
    }
}