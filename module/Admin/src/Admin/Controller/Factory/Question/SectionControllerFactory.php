<?php
/**
 * Zend Framework (http://framework.zend.com/)
*
* @link      http://github.com/zendframework/Template for the canonical source repository
* @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
* @license   http://framework.zend.com/license/new-bsd New BSD License
*/
namespace Admin\Controller\Factory\Question;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Controller\QuestionSectionController;

class SectionControllerFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator(); 
        $examsqa_question_section_service = $sm->get('examsqa_admin_question_section_service'); 
        $examsqa_question_service = $sm->get('examsqa_admin_question_service');
        $questionSectionForm     = $sm->get('FormElementManager')->get('examsqa_admin_question_section_form');
        return new QuestionSectionController($examsqa_question_section_service, $questionSectionForm, $examsqa_question_service);
    }
}