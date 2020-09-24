<?php
namespace Application\Form\Factory\User;

use Application\Form\User\ProfileForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProfileFormFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $userRepository = $serviceLocator->get('examsqa_application_user_repository');
        return new ProfileForm($userRepository, $serviceLocator);
    }
}