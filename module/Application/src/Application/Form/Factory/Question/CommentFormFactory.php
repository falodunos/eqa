<?php
namespace Application\Form\Factory\Question;

use Application\Form\Question\CommentForm as QuestionCommentForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CommentFormFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $questionCommentRepository = $serviceLocator->get('examsqa_application_question_comment_repository');
        return new QuestionCommentForm($questionCommentRepository);
    }
}