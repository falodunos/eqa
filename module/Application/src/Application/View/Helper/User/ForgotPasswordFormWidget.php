<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\View\Helper\User;

use Zend\View\Helper\AbstractHelper;
use GoalioForgotPassword\Form\Forgot as ForgotPasswordForm;
use Zend\View\Model\ViewModel;

/**
 * Render View Partial Cross Module
 */
class ForgotPasswordFormWidget extends AbstractHelper
{

    /**
     * $var string template used for view
     */
    protected $viewTemplate;

    protected $_forgotPasswordForm;

    public function __construct(ForgotPasswordForm $forgotPasswordForm, $viewTemplate)
    {
        $this->setViewTemplate($viewTemplate);
        $this->_forgotPasswordForm = $forgotPasswordForm;
    }

    public function __invoke($options = array())
    {
        if (array_key_exists('render', $options)) {
            $render = $options['render'];
        } else {
            $render = true;
        }
        
        $vm = new ViewModel(array(
            'forgotForm' => $this->_forgotPasswordForm
        ));
        $vm->setTemplate($this->viewTemplate);
        if ($render) {
            return $this->getView()->render($vm);
        } else {
            return $vm;
        }
    }

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
