<?php
namespace Admin\Repository\Question;

use Base\Repository\BaseDbRepository;
use Admin\Repository\Contract\Question\PaperRepositoryInterface as QuestionPaperRepositoryInterface;

class PaperRepository extends BaseDbRepository implements QuestionPaperRepositoryInterface
{

    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\Question\PaperRepositoryInterface::fetchByExamYear()
     */
    public function fetchByExamYear($examYear)
    {
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\Question\PaperRepositoryInterface::fetchByIsActive()
     */
    public function fetchByIsActive($examIsActive)
    {
        // TODO Auto-generated method stub
    }

    public function loadFilteredQuestionPapers($user)
    {
        $instId = !is_null($user->getIdentity()->getInstitution()) ? $user->getIdentity()->getInstitution()->getId() : null;
        $deptId = !is_null($user->getIdentity()->getDepartment()) ? $user->getIdentity()->getDepartment()->getId() : null;
        
        $qb = $this->_em->createQueryBuilder();
        $qb->select('qp')
            ->from('Admin\Entity\Question\Paper', 'qp')
            ->where('qp.institution = :instId')
            ->andWhere('qp.department = :deptId')
            ->orderBy('qp.paperName', 'ASC')
            ->setParameters(array(
            'instId' => $instId,
            'deptId' => $deptId
        ));
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getExamPapers($user, $examId = null)
    {
        $instId = !is_null($user->getIdentity()->getInstitution()) ? $user->getIdentity()->getInstitution()->getId() : null;
        $deptId = !is_null($user->getIdentity()->getDepartment()) ? $user->getIdentity()->getDepartment()->getId() : null;
        
        
        if ($examId) {
            return $this->findBy(array('paperExam'=>$examId));
//             $qb = $this->_em->createQueryBuilder();
//             $qb->select('qp')
//                 ->from($this->getEntityClass(), 'qp')
//                 ->where('qp.paperExam = :id')
//                 ->andWhere('qp.institution = :instId')
//                 ->andWhere('qp.department = :deptId')
//                 ->orderBy('qp.paperName', 'ASC')
//                 ->setParameters(array(
//                 'id' => $examId,
//                 'instId' => $instId,
//                 'deptId' => $deptId
//             ));
//             $query = $qb->getQuery();
//             return $query->getResult();
        }
        
        $re = $this->_em->getRepository($this->getEntityClass());
        return $re->findAll();
    }
}