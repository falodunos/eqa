<?php
namespace Application\Service;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Admin\Entity\Exam;
class FormService  implements ServiceManagerAwareInterface
{
    protected $_serviceLocator = null;
    protected $_registerForm = null;
    protected $serviceManager = null;
    // all possible depencies must be received in this constructor ...
    public function __construct(ServiceLocatorInterface $ServiceLocator)
    {
       $this->_serviceLocator = $ServiceLocator;
    }

    public function getRegisterForm()
    {
        is_null($this->_registerForm)? $this->_registerForm = $this->_serviceLocator->get('zfcuser_register_form'):"";
        return $this->_registerForm;
    }
    
    /**
     * Set service manager instance
     *
     * @param ServiceManager $serviceManager
     * @return Exam
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
}