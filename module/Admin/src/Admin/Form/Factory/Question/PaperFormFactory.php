<?php
namespace Admin\Form\Factory\Question;

use Admin\Form\Question\PaperForm as QuestionPaperForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PaperFormFactory implements FactoryInterface
{

    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $questionPaperRepository = $serviceLocator->get('examsqa_admin_question_paper_repository');
        return new QuestionPaperForm($questionPaperRepository, $serviceLocator);
    }
}