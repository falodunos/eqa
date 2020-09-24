<?php
namespace Base\Form\Element\Factory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use  Base\Form\Element\PhoneNumber;

class PhoneNumberFactory implements FactoryInterface{
	/* (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new PhoneNumber();
    }
}