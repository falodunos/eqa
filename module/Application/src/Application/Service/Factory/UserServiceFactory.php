<?php
namespace Application\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Application\Service\UserService;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserServiceFactory implements FactoryInterface
{

    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $userIdentityService = $serviceLocator->get('examsqa_application_user_identity_service');
        return new UserService($userIdentityService, $serviceLocator);
    }
}