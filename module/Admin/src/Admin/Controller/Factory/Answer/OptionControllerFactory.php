<?php
/**
 * Zend Framework (http://framework.zend.com/)
*
* @link      http://github.com/zendframework/Template for the canonical source repository
* @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
* @license   http://framework.zend.com/license/new-bsd New BSD License
*/
namespace Admin\Controller\Factory\Answer;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Controller\AnswerOptionController;

class OptionControllerFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator(); 
        $examsqa_answer_option_service = $sm->get('examsqa_admin_answer_option_service');
        $answerOptionForm     = $sm->get('FormElementManager')->get('examsqa_admin_answer_option_form');
        return new AnswerOptionController($examsqa_answer_option_service, $answerOptionForm);
    }
}