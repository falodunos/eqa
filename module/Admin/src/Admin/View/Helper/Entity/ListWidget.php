<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\View\Helper\Entity;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Render View Partial Cross Module
 */
class ListWidget extends AbstractHelper
{
    protected $examsqa_base_application_service = null;
    protected $_serviceLocator = null;
    protected $_sm = null;
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->_serviceLocator = $serviceLocator;
        $this->_sm = $this->_serviceLocator->getServiceLocator(); 
    }

    public function __invoke($entity_service_key, $template_service_function)
    {
        $entity_service = $this->_sm->get($entity_service_key);
        $entity_list_html = $entity_service->$template_service_function();
        return $this->getView()->render('admin/widget/entity/list', array(
            'entity_list' => $entity_list_html
        ));
    }
}
