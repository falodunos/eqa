<?php
namespace Admin\Form\Factory;

use Admin\Form\QuestionForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QuestionFormFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $questionRepository = $serviceLocator->get('examsqa_admin_question_repository');
        return new QuestionForm($questionRepository, $serviceLocator);
    }
}