<?php
namespace Application\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Base\Service\BaseErrorHandlingService;
use Zend\ServiceManager\ServiceLocatorInterface;

class BaseErrorHandlingServiceFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $zendLogger = $serviceLocator->get('\Zend\Log');
        return new BaseErrorHandlingService($zendLogger);
    }
}