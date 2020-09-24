<?php
namespace Admin\Form\Factory;

use Admin\Form\SubjectForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SubjectFormFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $examsqa_subject_repository = $serviceLocator->get('examsqa_admin_subject_repository');
        return new SubjectForm($examsqa_subject_repository, $serviceLocator);
    }
}