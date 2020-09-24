<?php
namespace Admin\Service\Contract\Question;

use Admin\Entity\Contract\Question\PaperInterface as QuestionPaperInterface;

interface PaperServiceInterface
{

    public function findAllQuestionPapers();

    /**
     *
     * @param integer $id            
     */
    public function findQuestionPaper($id);
    
    /**
     *
     * @param integer $id
     */
    public function findQuestionPaperBy($criteria);

    /**
     *
     * @param QuestionPaperInterface $questionPaper            
     */
    public function saveQuestionPaper($post);

    /**
     *
     * @param QuestionPaperInterface $questionPaper            
     */
    public function deleteQuestionPaper(QuestionPaperInterface $questionPaper);
}