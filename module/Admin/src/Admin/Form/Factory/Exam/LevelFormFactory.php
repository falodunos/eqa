<?php
namespace Admin\Form\Factory\Exam;

use Admin\Form\Exam\LevelForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LevelFormFactory implements FactoryInterface
{
protected $events;
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $examsqa_level_repository = $serviceLocator->get('examsqa_admin_level_repository'); 
        return new LevelForm($examsqa_level_repository);
    }
}