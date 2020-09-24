<?php
namespace Admin\Entity\Contract\Question;

use Base\Entity\Contract\BaseEntityInterface;

interface SectionInterface extends BaseEntityInterface
{

    /**
     * Get SectionName.
     *
     * @return string
     */
    public function getSectionName();

    /**
     * Set SectionName.
     *
     * @param string $sectionName            
     * @return SectionInterface
     */
    public function setSectionName($sectionName);

    /**
     * Get SectionDescription.
     *
     * @return string
     */
    public function getSectionDescription();

    /**
     * Set SectionDescription.
     *
     * @param string $sectionDescription            
     * @return SectionInterface
     */
    public function setSectionDescription($sectionDescription);
    
    /**
     * Get SectionPaper.
     *
     * @return string
     */
    public function getSectionPaper();
    
    /**
     * Set SectionPaper.
     *
     * @param string $sectionPaper
     * @return SectionInterface
    */
    public function setSectionPaper($sectionPaper);
}