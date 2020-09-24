<?php
namespace Admin\Service\Factory\Question;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Service\Question\SectionService as QuestionSectionService;

class SectionServiceFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    { 
        return new QuestionSectionService($serviceLocator);
    }
}