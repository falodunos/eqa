<?php
namespace Admin\Service\Contract\Answer;

use Admin\Entity\Contract\AnswerOptionInterface;

interface OptionServiceInterface
{

    public function findAllAnswerOptions();

    /**
     *
     * @param integer $id            
     */
    public function findAnswerOption($id);
    
    /**
     *
     * @param integer $id
     */
    public function findAnswerOptionsByQuestion($questionId);
    
    /**
     *
     * @param integer $id
     */
    public function findCorrectAnswerOptionsByQuestion($questionId);

    /**
     *
     * @param AnswerOptionInterface $answerOption            
     */
    public function saveAnswerOption($answerOption);

    /**
     *
     * @param AnswerOptionInterface $answerOption            
     */
    public function deleteAnswerOption($answerOptionId);
}