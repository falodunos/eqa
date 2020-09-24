<?php
namespace Admin\Service\Factory\Academic;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Service\Academic\InstitutionService;

class InstitutionServiceFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    { 
        return new InstitutionService($serviceLocator);
    }
}