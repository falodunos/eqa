<?php
namespace Admin\Service\Contract;

use Admin\Entity\Contract\SubjectInterface;

interface SubjectServiceInterface
{

    public function findAllSubjects();

    /**
     *
     * @param integer $id            
     */
    public function findSubject($id);

    /**
     *
     * @param ExamInterface $subject            
     */
    public function saveSubject($subject_data);

    /**
     *
     * @param ExamInterface $subject            
     */
    public function deleteSubject(SubjectInterface $subject);
    
    public function findSubjectBy(array $criteria);
}