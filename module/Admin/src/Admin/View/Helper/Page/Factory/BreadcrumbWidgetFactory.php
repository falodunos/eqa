<?php
namespace Admin\View\Helper\Page\Factory;

use Zend\ServiceManager\FactoryInterface;
use Admin\View\Helper\Page\BreadcrumbWidget;
use Zend\ServiceManager\ServiceLocatorInterface;

class BreadcrumbWidgetFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    protected $_serviceLocator = null;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->_serviceLocator = $serviceLocator;
        return new BreadcrumbWidget($this->_serviceLocator);
    }
}