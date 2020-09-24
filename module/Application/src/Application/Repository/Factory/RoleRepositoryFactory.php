<?php
namespace Application\Repository\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Repository\RoleRepository;

class RoleRepositoryFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $meta = $em->getClassMetadata('Application\Entity\Role');
        return new RoleRepository($em, $meta);
    }
}