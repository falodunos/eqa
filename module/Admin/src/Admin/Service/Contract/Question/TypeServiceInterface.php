<?php
namespace Admin\Service\Contract\Question;

use Admin\Entity\Contract\Question\TypeInterface as QuestionTypeInterface;

interface TypeServiceInterface
{

    public function findAllQuestionTypes();

    /**
     *
     * @param integer $id            
     */
    public function findQuestionType($id);

    /**
     *
     * @param QuestionSectionInterface $questionType            
     */
    public function saveQuestionType($post);

    /**
     *
     * @param QuestionSectionInterface $questionType            
     */
    public function deleteQuestionType(QuestionTypeInterface $questionSection);
}