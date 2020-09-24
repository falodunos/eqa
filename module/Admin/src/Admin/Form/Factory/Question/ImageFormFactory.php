<?php
namespace Admin\Form\Factory\Question;

use Admin\Form\Question\ImageForm as QuestionImageForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ImageFormFactory implements FactoryInterface
{

    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $questionImageRepository = $serviceLocator->get('examsqa_admin_question_image_repository');
        return new QuestionImageForm($questionImageRepository, $serviceLocator);
    }
}