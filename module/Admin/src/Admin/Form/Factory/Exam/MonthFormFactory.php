<?php
namespace Admin\Form\Factory\Exam;

use Admin\Form\Exam\MonthForm as ExamMonthForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MonthFormFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $examMonthRepository = $serviceLocator->get('examsqa_admin_exam_month_repository');
        return new ExamMonthForm($examMonthRepository);
    }
}