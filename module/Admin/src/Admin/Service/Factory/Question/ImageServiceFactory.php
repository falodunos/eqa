<?php
namespace Admin\Service\Factory\Question;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Service\Question\ImageService as QuestionImageService;

class ImageServiceFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    { 
        return new QuestionImageService($serviceLocator);
    }
}