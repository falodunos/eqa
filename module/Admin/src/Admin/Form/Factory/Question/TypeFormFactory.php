<?php
namespace Admin\Form\Factory\Question;

use Admin\Form\Question\TypeForm as QuestionTypeForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TypeFormFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $questionTypeRepository = $serviceLocator->get('examsqa_admin_question_type_repository');
        return new QuestionTypeForm($questionTypeRepository);
    }
}