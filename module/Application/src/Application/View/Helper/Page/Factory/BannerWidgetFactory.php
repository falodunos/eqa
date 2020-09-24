<?php
namespace Application\View\Helper\Page\Factory;
use Zend\ServiceManager\FactoryInterface;
use Application\View\Helper\Page\BannerWidget;
use Zend\ServiceManager\ServiceLocatorInterface;

class BannerWidgetFactory implements FactoryInterface{ 
    /* (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    protected $_serviceLocator = null;
    public function createService(ServiceLocatorInterface $serviceLocator)
    {   
        $this->_serviceLocator = $serviceLocator; 
        $examsqa_base_application_service = $this->_serviceLocator->getServiceLocator()->get('examsqa_base_application_service');
        return new BannerWidget($examsqa_base_application_service);
    }
}