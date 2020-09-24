<?php
namespace Application\View\Helper\Service;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorInterface;

class Manager extends AbstractHelper
{
    protected $_sm;
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->_sm = $serviceLocator->getServiceLocator();
    }

    public function __invoke()
    {
        return $this->_sm;
    }
}