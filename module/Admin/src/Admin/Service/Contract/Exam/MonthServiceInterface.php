<?php
namespace Admin\Service\Contract\Exam;

use Admin\Entity\Contract\Exam\MonthInterface as ExamMonthInterface;

interface MonthServiceInterface
{

    public function findAllExamMonths();

    /**
     *
     * @param integer $id            
     */
    public function findExamMonth($id);

    /**
     *
     * @param ExamInterface $examMonth            
     */
    public function saveExamMonth($post);

    /**
     *
     * @param ExamInterface $examMonth            
     */
    public function deleteExam(ExamMonthInterface $examMonth);
}