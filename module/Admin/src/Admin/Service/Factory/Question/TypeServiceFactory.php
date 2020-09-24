<?php
namespace Admin\Service\Factory\Question;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Service\Question\TypeService as QuestionTypeService;

class TypeServiceFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    { 
        return new QuestionTypeService($serviceLocator);
    }
}