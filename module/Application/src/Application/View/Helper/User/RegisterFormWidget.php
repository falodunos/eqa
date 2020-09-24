<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\View\Helper\User;

use Zend\View\Helper\AbstractHelper;
use Application\Service\FormService;
use Zend\View\Model\ViewModel;

/**
 * Render View Partial Cross Module
 */
class RegisterFormWidget extends AbstractHelper
{

    protected $examsqa_application_service_formsevice = null;

    /**
     * $var string template used for view
     */
    protected $viewTemplate;

    public function __construct(FormService $examsqa_application_service_formsevice, $viewTemplate)
    {
        $this->examsqa_application_service_formsevice = $examsqa_application_service_formsevice;
        $this->setViewTemplate($viewTemplate);
    }

    public function __invoke($options = array())
    {
        if (array_key_exists('render', $options)) {
            $render = $options['render'];
        } else {
            $render = true;
        }
        if (array_key_exists('redirect', $options)) {
            $redirect = $options['redirect'];
        } else {
            $redirect = false;
        }
        if (array_key_exists('enableRegistration', $options)) {
            $enableRegistration = $options['enableRegistration'];
        } else {
            $enableRegistration = false;
        }
        
        $vm = new ViewModel(array(
            'enableRegistration' => $enableRegistration,
            'registerForm' => $this->examsqa_application_service_formsevice->getRegisterForm(),
            'redirect' => $redirect
        ));
        $vm->setTemplate($this->viewTemplate);
        if ($render) {
            return $this->getView()->render($vm);
        } else {
            return $vm;
        }
    }
    
    // public function __invoke() {
    // $registerForm = $this->examsqa_application_service_formsevice->getRegisterForm();
    // return $this->getView()->render(
    // 'application/widget/form/user/register',
    // array(
    // 'enableRegistration' => true,//$this->getOptions()->getEnableRegistration(),
    // 'redirect' => false,
    // 'registerForm' => $registerForm)
    // );
    // }
    
    /**
     *
     * @param string $viewTemplate            
     * @return ZfcUserLoginWidget
     */
    public function setViewTemplate($viewTemplate)
    {
        $this->viewTemplate = $viewTemplate;
        return $this;
    }
}
