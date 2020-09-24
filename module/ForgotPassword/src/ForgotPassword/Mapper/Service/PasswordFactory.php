<?php
namespace ForgotPassword\Mapper\Service;

use ForgotPassword\Mapper\Password;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class PasswordFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('goalioforgotpassword_module_options');
        $entityClass = $options->getPasswordEntityClass(); 
        
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $meta = $em->getClassMetadata($entityClass);
        
        $mapper = new Password($em, $meta, $options);
        return $mapper;
    }
}