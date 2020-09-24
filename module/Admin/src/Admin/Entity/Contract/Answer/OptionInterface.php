<?php
namespace Admin\Entity\Contract\Answer;

use Base\Entity\Contract\BaseEntityInterface;

interface OptionInterface extends BaseEntityInterface
{

    /**
     * Get optionText.
     *
     * @return string
     */
    public function getOptionText();

    /**
     * Set optionText.
     *
     * @param string $optionText            
     * @return OptionInterface
     */
    public function setOptionText($optionText);

    /**
     * Get isCorrect.
     *
     * @return string
     */
    public function getIsCorrect();
    
    /**
     * Set optionText.
     *
     * @param string $isCorrect
     * @return OptionInterface
    */
    public function setIsCorrect($isCorrect);
    
    /**
     * Get question.
     *
     * @return string
     */
    public function getQuestion();

    /**
     * Set question.
     *
     * @param string $setQuestion         
     * @return OptionInterface
     */
    public function setQuestion($setQuestion);
}