<?php
namespace Application\View\Helper\User\Factory;
use Zend\ServiceManager\FactoryInterface;
use Application\View\Helper\User\RegisterFormWidget;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegisterFormWidgetFactory implements FactoryInterface{ 
    /* (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {   
        $examsqa_application_service_formsevice = $serviceLocator->getServiceLocator()->get('examsqa_application_service_formsevice');
        return new RegisterFormWidget($examsqa_application_service_formsevice, 'application/widget/form/user/register');
    }
}