<?php
namespace Admin\Form\Factory;

use Admin\Form\ExamForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExamFormFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $subjectRepository = $serviceLocator->get('examsqa_admin_subject_repository');
        $examRepository = $serviceLocator->get('examsqa_admin_exam_repository');
        return new ExamForm($examRepository, $subjectRepository, $serviceLocator);
    }
}