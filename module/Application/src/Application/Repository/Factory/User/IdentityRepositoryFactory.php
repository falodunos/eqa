<?php
namespace Application\Repository\Factory\User;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Repository\User\IdentityRepository as UserIdentityRepository;

class IdentityRepositoryFactory implements FactoryInterface
{

    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $meta = $em->getClassMetadata('Application\Entity\User\Identity');
        return new UserIdentityRepository($em, $meta);
    }
}       