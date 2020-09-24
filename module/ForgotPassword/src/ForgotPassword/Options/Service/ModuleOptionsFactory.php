<?php
namespace ForgotPassword\Options\Service;

use ForgotPassword\Options\ModuleOptions;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class ModuleOptionsFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        return new ModuleOptions(isset($config['goalioforgotpassword']) ? $config['goalioforgotpassword'] : array());
    }
}