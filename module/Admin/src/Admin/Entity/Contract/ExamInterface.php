<?php
namespace Admin\Entity\Contract;

use Base\Entity\Contract\BaseEntityInterface;
use Admin\Entity\Exam\Level;

interface ExamInterface extends BaseEntityInterface
{

    /**
     * Get examName.
     *
     * @return string
     */
    public function getExamName();

    /**
     * Set examName.
     *
     * @param string $examName            
     * @return ExamInterface
     */
    public function setExamName($examName);

    /**
     * Get dateEstablished.
     *
     * @return string
     */
    public function getDateEstablished();

    /**
     * Set dateEstablished.
     *
     * @param string $dateEstablished            
     * @return ExamInterface
     */
    public function setDateEstablished($dateEstablished);

    /**
     * Get examCode.
     *
     * @return string
     */
    public function getExamCode();

    /**
     * Set examCode.
     *
     * @param string $examCode            
     * @return ExamInterface
     */
    public function setExamCode($examCode);

    /**
     * Get examLevel.
     *
     * @return string
     */
    public function getExamLevel();

    /**
     * Set examLevel.
     *
     * @param string $examLevel            
     * @return ExamInterface
     */
    public function setExamlevel(Level $examLevel = null);

    /**
     * Get examDescription.
     *
     * @return string
     */
    public function getExamDescription();

    /**
     * Set examType.
     *
     * @param string $examDescription            
     * @return ExamInterface
     */
    public function setExamDescription($examDescription);

}