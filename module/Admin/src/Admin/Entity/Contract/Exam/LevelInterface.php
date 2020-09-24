<?php
namespace Admin\Entity\Contract\Exam;

use Base\Entity\Contract\BaseEntityInterface;

interface LevelInterface extends BaseEntityInterface
{

    /**
     * Get levelName.
     *
     * @return string
     */
    public function getLevelName();

    /**
     * Set levelName.
     *
     * @param string $levelName            
     * @return LevelInterface
     */
    public function setLevelName($levelName);
    
    /**
     * Get levelCode.
     *
     * @return string
     */
    public function getLevelCode();
    
    /**
     * Set levelCode.
     *
     * @param string $levelCode
     * @return LevelInterface
    */
    public function setLevelCode($levelCode);
    

    /**
     * Get levelDescription
     *
     * @return string
     */
    public function getLevelDescription();

    /**
     * Set levelDescription.
     *
     * @param string $levelDescription            
     * @return LevelInterface
     */
    public function setLevelDescription($levelDescription);
}