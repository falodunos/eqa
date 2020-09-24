<?php
namespace Admin\Form\Factory\Question;

use Admin\Form\Question\SectionForm as QuestionSectionForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SectionFormFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $questionSectionRepository = $serviceLocator->get('examsqa_admin_question_section_repository');
        return new QuestionSectionForm($questionSectionRepository, $serviceLocator);
    }
}