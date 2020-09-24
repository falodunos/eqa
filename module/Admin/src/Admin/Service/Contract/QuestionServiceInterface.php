<?php
namespace Admin\Service\Contract;

use Admin\Entity\Contract\QuestionInterface;

interface QuestionServiceInterface
{

    public function findAllQuestions();

    /**
     *
     * @param integer $id            
     */
    public function findQuestion($id);

    /**
     *
     * @param QuestionInterface $question            
     */
    public function saveQuestion($post);

    /**
     *
     * @param QuestionInterface $question            
     */
    public function deleteQuestion(QuestionInterface $question);
}