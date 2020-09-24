<?php
namespace Admin\Entity\Contract;

use Base\Entity\Contract\BaseEntityInterface;

interface SubjectInterface extends BaseEntityInterface
{

    /**
     * Get SubjectName.
     *
     * @return string
     */
    public function getSubjectName();

    /**
     * Set SubjectName.
     *
     * @param string $subjectName            
     * @return SubjectInterface
     */
    public function setSubjectName($subjectName);

    /**
     * Get SubjectCode.
     *
     * @return string
     */
    public function getSubjectCode();

    /**
     * Set SubjectCode.
     *
     * @param string $subjectCode            
     * @return SubjectInterface
     */
    public function setSubjectCode($subjectCode);

    /**
     * Get SubjectDescription.
     *
     * @return string
     */
    public function getSubjectDescription();

    /**
     * Set SubjectDescription.
     *
     * @param string $subjectDescription            
     * @return SubjectInterface
     */
    public function setSubjectDescription($subjectDescription);
}