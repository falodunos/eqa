<?php
namespace Admin\Service\Contract\Question;

use Admin\Entity\Contract\Question\SectionInterface as QuestionSectionInterface;

interface SectionServiceInterface
{

    public function findAllQuestionSections();

    /**
     *
     * @param integer $id            
     */
    public function findQuestionSection($id);
    
    /**
     *
     * @param integer $id
     */
    public function findQuestionSectionBy($criteria);

    /**
     *
     * @param QuestionSectionInterface $questionSection            
     */
    public function saveQuestionSection($post);

    /**
     *
     * @param QuestionSectionInterface $questionSection            
     */
    public function deleteQuestionSection(QuestionSectionInterface $questionSection);
}