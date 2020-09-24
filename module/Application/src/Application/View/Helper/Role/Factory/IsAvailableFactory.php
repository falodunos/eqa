<?php
namespace Application\View\Helper\Role\Factory;

use Zend\ServiceManager\FactoryInterface;
use Application\View\Helper\Role\IsAvailable;
use Zend\ServiceManager\ServiceLocatorInterface;

class IsAvailableFactory implements FactoryInterface
{

    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    protected $_serviceLocator = null;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new IsAvailable($serviceLocator);
    }
}