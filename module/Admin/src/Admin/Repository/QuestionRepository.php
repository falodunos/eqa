<?php
namespace Admin\Repository;

use Base\Repository\BaseDbRepository;
use Admin\Repository\Contract\QuestionRepositoryInterface;

class QuestionRepository extends BaseDbRepository implements QuestionRepositoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\QuestionRepositoryInterface::fetchByQpaper()
     */
    public function fetchByQpaper($questionPaper)
    {
        // TODO Auto-generated method stub
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\QuestionRepositoryInterface::fetchByQsection()
     */
    public function fetchByQsection($questionSection)
    {
        // TODO Auto-generated method stub
    }

    public function getSectionQuestions($user, $sectionId = null)
    { // $this->getEntityClass() = 'Admin\Entity\Question'
        
        if ($sectionId) {
            
//             $instId = !is_null($user->getIdentity()->getInstitution()) ? $user->getIdentity()->getInstitution()->getId() : null;
//             $deptId = !is_null($user->getIdentity()->getDepartment()) ? $user->getIdentity()->getDepartment()->getId() : null;
            
//             $qb = $this->_em->createQueryBuilder();
//             $qb->select('q')
//                 ->from($this->getEntityClass(), 'q')
//                 ->where('q.questionSection = :id')
//                 ->andWhere('q.institution = :instId')
//                 ->andWhere('q.department = :deptId')
//                 ->orderBy('q.questionTag', 'ASC')
//                 ->setParameters(array(
//                 'id' => $sectionId,
//                 'instId' => $instId,
//                 'deptId' => $deptId
//             ));
//             $query = $qb->getQuery();
//             return $query->getResult();
        return $this->findBy(array('questionSection'=>$sectionId));
        }
        
        $re = $this->_em->getRepository($this->getEntityClass());
        return $re->findAll();
    }
}