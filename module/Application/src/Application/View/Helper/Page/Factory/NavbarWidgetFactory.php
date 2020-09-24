<?php
namespace Application\View\Helper\Page\Factory;
use Zend\ServiceManager\FactoryInterface;
use Application\View\Helper\Page\NavbarWidget;
use Zend\ServiceManager\ServiceLocatorInterface;

class NavbarWidgetFactory implements FactoryInterface{ 
    /* (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    protected $_serviceLocator = null;
    public function createService(ServiceLocatorInterface $serviceLocator)
    {   
        $this->_serviceLocator = $serviceLocator; 
        return new NavbarWidget($this->_serviceLocator);
    }
}