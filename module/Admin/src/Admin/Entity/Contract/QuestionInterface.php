<?php
namespace Admin\Entity\Contract;

use Base\Entity\Contract\BaseEntityInterface;

interface QuestionInterface extends BaseEntityInterface
{

    /**
     * Get questionText.
     *
     * @return string
     */
    public function getQuestionText();

    /**
     * Set questionText.
     *
     * @param string $questionText            
     * @return QuestionInterface
     */
    public function setQuestionText($questionText);

    /**
     * Get answer.
     *
     * @return string
     */
    public function getAnswer();

    /**
     * Set questionText.
     *
     * @param string $answer            
     * @return QuestionInterface
     */
    public function setAnswer($answer);
}