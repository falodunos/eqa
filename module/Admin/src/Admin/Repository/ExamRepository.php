<?php
namespace Admin\Repository;

use Base\Repository\BaseDbRepository;
use Admin\Repository\Contract\ExamRepositoryInterface;
use Admin\Entity\Exam\Certificate;
use Admin\Entity\Exam\Level;
use Admin\Entity\Exam;

class ExamRepository extends BaseDbRepository implements ExamRepositoryInterface
{

    protected $_exam = null;
    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\ExamRepositoryInterface::findByCode()
     */
    public function findByCode($examCode)
    {
        // TODO Auto-generated method stub
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\ExamRepositoryInterface::getByLevel()
     */
    public function getByLevel($examLevel)
    {
        // TODO Auto-generated method stub
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\ExamRepositoryInterface::getByYear()
     */
    public function getByYear($examYear)
    {
        // TODO Auto-generated method stub
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\ExamRepositoryInterface::getByType()
     */
    public function getByType($examType)
    {
        // TODO Auto-generated method stub
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\ExamRepositoryInterface::getByCertificate()
     */
    public function getByCertificate($examCertificate)
    {
        // TODO Auto-generated method stub
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\ExamRepositoryInterface::getByIsActive()
     */
    public function getByIsActive($examIsActive)
    {
        // TODO Auto-generated method stub
    }

    public function loadExamCertificates()
    {
        $cert = new Certificate();
        $re = $this->_em->getRepository($cert->getEntityClass());
        return $re->findAll();
    }

    public function getExamLevels()
    {
        $level = new Level();
        $re = $this->_em->getRepository($level->getEntityClass());
        return $re->findAll();
    }

    public function getExams()
    {
        $re = $this->_em->getRepository($this->_getExam()
            ->getEntityClass());
        return $re->findAll();
    }

    protected function _getExam()
    {
        if (is_null($this->_exam)) {
            $this->_exam = new Exam();
        }
        return $this->_exam;
    }
    
    public function getExamsByInstitutionAndDepartment(){
        $instId = 1; $deptId = 1;
        $qb = $this->_em->createQueryBuilder();
        $qb->select('exam')
        ->from('Admin\Entity\Exam', 'exam')
        ->where('exam.institution = :instId')
        ->andWhere('exam.department = :deptId')
        ->orderBy('exam.examName', 'ASC')
        ->setParameters(array(
            'instId' => $instId,
            'deptId' => $deptId
        ));
        $query = $qb->getQuery();
        return $query->getResult();
    }
}