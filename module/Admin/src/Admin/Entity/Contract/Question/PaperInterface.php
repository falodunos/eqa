<?php
namespace Admin\Entity\Contract\Question;

use Base\Entity\Contract\BaseEntityInterface;

interface PaperInterface extends BaseEntityInterface
{

    /**
     * Get PaperYear.
     *
     * @return string
     */
    public function getPaperYear();

    /**
     * Set paperYear.
     *
     * @param string $paperYear            
     * @return PaperInterface
     */
    public function setPaperYear($paperYear);

    /**
     * Get examMonth.
     *
     * @return string
     */
    public function getExamMonth();

    /**
     * Set examMounth.
     *
     * @param string $examMonth            
     * @return PaperInterface
     */
    public function setExamMonth($examMonth);

    /**
     * Get paperDuration.
     *
     * @return string
     */
    public function getPaperDuration();

    /**
     * Set paperDuration.
     *
     * @param string $paperDuration            
     * @return PaperInterface
     */
    public function setPaperDuration($paperDuration);
    
    /**
     * Get paperInstruction.
     *
     * @return string
     */
    public function getPaperInstruction();
    
    /**
     * Set paperInstruction.
     *
     * @param string $paperInstruction
     * @return PaperInterface
    */
    public function setPaperInstruction($paperInstruction);
}