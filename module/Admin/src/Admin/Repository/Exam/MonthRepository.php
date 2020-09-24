<?php
namespace Admin\Repository\Exam;

use Base\Repository\BaseDbRepository;
use Admin\Repository\Contract\Exam\MonthRepositoryInterface as ExamMonthRepositoryInterface;
use Admin\Entity\Exam\Month;

class MonthRepository extends BaseDbRepository implements ExamMonthRepositoryInterface
{

    protected $_examMonth = null;
    
    public function getExamMonths()
    {
        $re = $this->_em->getRepository($this->_getMonth()->getEntityClass());
        return $re->findAll();
    }
    protected function _getMonth()
    {
        if (is_null($this->_examMonth)) {
            $this->_examMonth = new Month();
        }
        return $this->_examMonth;
    }
	/* (non-PHPdoc)
     * @see \Admin\Repository\Contract\Exam\MonthRepositoryInterface::fetchByIsActive()
     */
    public function fetchByIsActive($examMonthIsActive)
    {
        // TODO Auto-generated method stub
        
    }

}