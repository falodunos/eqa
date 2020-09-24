<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\View\Helper\Page;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Render View Partial Cross Module
 */
class BreadcrumbWidget extends AbstractHelper
{

    protected $examsqa_base_application_service = null;
    protected $_serviceLocator = null;
    protected $_sm = null;
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->_serviceLocator = $serviceLocator;
        $this->_sm = $this->_serviceLocator->getServiceLocator();
    }

    public function __invoke($breadcrumb_urls = array())
    {
        return $this->getView()->render('admin/widget/page/breadcrumb', array(
            'urls' => $breadcrumb_urls
        ));
    }
}
