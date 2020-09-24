<?php
namespace Application\Service\Factory\Authentication\Storage;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Service\Authentication\Storage\Session;

class SessionServiceFactory implements FactoryInterface
{

    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $namespace = $member = $manager = null;
        return new Session($namespace, $member, $manager);
    }
}