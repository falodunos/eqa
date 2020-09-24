<?php
namespace Application\View\Helper\User\Factory;

use Zend\ServiceManager\FactoryInterface;
use Application\View\Helper\User\ForgotPasswordFormWidget;
use Zend\ServiceManager\ServiceLocatorInterface;

class ForgotPasswordFormWidgetFactory implements FactoryInterface
{

    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $forgotPasswordForm = $serviceLocator->getServiceLocator()->get('goalioforgotpassword_forgot_form');
        return new ForgotPasswordFormWidget($forgotPasswordForm, 'application/widget/form/user/goalio-forgot-password/forgot/forgot');
    }
}