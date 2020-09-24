<?php
namespace Admin\Service\Contract;

use Admin\Entity\Contract\ExamInterface;

interface ExamServiceInterface
{

    public function findAllExams();
    
    public function findExamsBy($criteria);

    /**
     *
     * @param integer $id            
     */
    public function findExam($id);

    /**
     *
     * @param ExamInterface $exam            
     */
    public function saveExam($exam_data);

    /**
     *
     * @param ExamInterface $exam            
     */
    public function deleteExam(ExamInterface $exam);
}