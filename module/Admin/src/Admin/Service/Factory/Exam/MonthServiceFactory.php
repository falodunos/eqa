<?php
namespace Admin\Service\Factory\Exam;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Service\Exam\MonthService as ExamMonthService;

class MonthServiceFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ExamMonthService($serviceLocator);
    }
}