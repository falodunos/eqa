<?php
namespace Application\Service\Factory\User;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Application\Service\User\IdentityService as UserIdentityService;
// use Zend\Validator\Identical;
class IdentityServiceFactory implements FactoryInterface
{

    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $userIdentityRepository = $serviceLocator->get('examsqa_application_user_identity_repository');
        return new UserIdentityService($serviceLocator, $userIdentityRepository);
    }
}
