<?php

namespace Application\View\Helper\Service\Factory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\View\Helper\Service\Manager as ServiceManager;
class ManagerFactory implements FactoryInterface{
 /* (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ServiceManager($serviceLocator);
    }

    
}