<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\View\Helper\Page;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 * Render View Partial Cross Module
 */
class NavbarWidget extends AbstractHelper
{

    protected $_serviceLocator;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->_serviceLocator = $serviceLocator;
    }

    public function __invoke()
    {
        return $this->getView()->render('application/widget/page/navbar');
    }
}
