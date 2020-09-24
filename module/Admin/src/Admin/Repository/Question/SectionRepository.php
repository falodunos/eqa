<?php
namespace Admin\Repository\Question;

use Base\Repository\BaseDbRepository;
use Admin\Repository\Contract\Question\SectionRepositoryInterface as QuestionSectionRepositoryInterface;
// use Admin\Entity\Question\Section as QuestionSection;

class SectionRepository extends BaseDbRepository implements QuestionSectionRepositoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\Question\SectionRepositoryInterface::fetchByExam()
     */
    public function fetchByExam($exam)
    {
        
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\Question\SectionRepositoryInterface::fetchBySubject()
     */
    public function fetchBySubject($subject)
    {
        
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\Question\SectionRepositoryInterface::fetchByIsActive()
     */
    public function fetchByIsActive($sectionIsActive)
    {
        
    }

    public function loadPaperSections($paperId = null)
    {
        if ($paperId) {
            $qb = $this->_em->createQueryBuilder();
            $qb->select('qs')
                ->from($this->getEntityClass(), 'qs') // $this->getEntityClass() = 'Admin\Entity\Question\QuestionSection'
                ->where('qs.sectionPaper = :id')
                ->orderBy('qs.sectionName', 'ASC')
                ->setParameter('id', $paperId);
            $query = $qb->getQuery();
            return $query->getResult();
        }
       
        $re = $this->_em->getRepository($this->getEntityClass());
        return $re->findAll();
    }
}