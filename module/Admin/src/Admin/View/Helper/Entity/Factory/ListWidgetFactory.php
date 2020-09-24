<?php
namespace Admin\View\Helper\Entity\Factory;

use Zend\ServiceManager\FactoryInterface;
use Admin\View\Helper\Entity\ListWidget;
use Zend\ServiceManager\ServiceLocatorInterface;

class ListWidgetFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    protected $_serviceLocator = null;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->_serviceLocator = $serviceLocator;
        return new ListWidget($this->_serviceLocator);
    }
}