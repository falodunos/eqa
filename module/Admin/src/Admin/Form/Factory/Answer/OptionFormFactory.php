<?php
namespace Admin\Form\Factory\Answer;

use Admin\Form\Answer\OptionForm as AnswerOptionForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
// use Zend\Di\ServiceLocator;

class OptionFormFactory implements FactoryInterface
{
protected $events;
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $examsqa_answer_option_repository = $serviceLocator->get('examsqa_admin_answer_option_repository'); 
        return new AnswerOptionForm($examsqa_answer_option_repository, $serviceLocator);
    }
}