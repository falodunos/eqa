<?php
namespace Application\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Application\Service\RoleService;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleServiceFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RoleService($serviceLocator);
    }
}