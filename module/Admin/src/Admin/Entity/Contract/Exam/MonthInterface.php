<?php
namespace Admin\Entity\Contract\Exam;

use Base\Entity\Contract\BaseEntityInterface;

interface MonthInterface extends BaseEntityInterface
{

    /**
     * Get $examMonth.
     *
     * @return string
     */
    public function getExamMonth();

    /**
     * Set examMonth.
     *
     * @param string $examMonth            
     * @return MonthInterface
     */
    public function setExamMonth($examMonth);
    
}