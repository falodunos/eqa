<?php
namespace Application\Service\Factory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Application\Service\FormService;

class FormServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LoginForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $examsqa_application_form_service = new FormService($serviceLocator); 
        return $examsqa_application_form_service;
    }
}
