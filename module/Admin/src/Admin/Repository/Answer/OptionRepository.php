<?php
namespace Admin\Repository\Answer;

use Base\Repository\BaseDbRepository;
use Admin\Repository\Contract\Answer\OptionRepositoryInterface as AnswerOptionRepositoryInterface;

class OptionRepository extends BaseDbRepository implements AnswerOptionRepositoryInterface
{
	/* (non-PHPdoc)
     * @see \Admin\Repository\Contract\Answer\OptionRepositoryInterface::findeByIsActive()
     */
    public function findeByIsActive($optionIsActive)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \Admin\Repository\Contract\Answer\OptionRepositoryInterface::findByQuestion()
     */
    public function findByQuestion($question)
    {
        // TODO Auto-generated method stub
        
    }
    
    public function getAnswerOptions($post, $user){
//         $instId = !is_null($user->getIdentity()->getInstitution()) ? $user->getIdentity()->getInstitution()->getId() : null;
//         $deptId = !is_null($user->getIdentity()->getDepartment()) ? $user->getIdentity()->getDepartment()->getId() : null;
        
//         $qb = $this->_em->createQueryBuilder();
//         $qb->select('option')
//         ->from('Admin\Entity\Answer\Option', 'option')
//         ->where('option.institution = :instId')
//         ->andWhere('option.department = :deptId')
//         ->andWhere('option.questionExam = :examId')
//         ->andWhere('option.questionPaper = :paperId')
//         ->andWhere('option.questionSection = :sectionId')
//         ->andWhere('option.question = :questionId')
//         ->orderBy('option.id', 'ASC')
//         ->setParameters(array(
//             'instId' => $instId,
//             'deptId' => $deptId,
//             'examId' => $post['examId'],
//             'paperId' => $post['paperId'],
//             'sectionId' => $post['sectionId'],
//             'questionId' => $post['questionId']
//         ));
//         $query = $qb->getQuery();
//         return $query->getResult();
        $criteria = array(
            'questionExam'=>$post['examId'], 
            'questionPaper'=>$post['paperId'],
            'questionSection'=>$post['sectionId'],
            'question'=> $post['questionId']
        );
        return $this->findBy($criteria);
    }
}