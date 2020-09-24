<?php
namespace Admin\Entity\Exam;

use Base\Entity\BaseIdentityEntity;
use Doctrine\ORM\Mapping as ORM;
use Admin\Entity\Contract\Exam\LevelInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @author Solomon
 *         @ORM\Entity(repositoryClass="Admin\Repository\Exam\LevelRepository")
 *         @ORM\Table (name="exam_levels")
 */
class Level extends BaseIdentityEntity implements LevelInterface
{
    
    /* Defining entity protected member variables */
    /**
     * @ORM\Column(name="level_name", type="string", length=50, nullable=false)
     */
    protected $levelName;

    /**
     * @ORM\Column(name="level_code", type="string",length=10, nullable=true)
     */
    protected $levelCode;

    /**
     * @ORM\Column(name="level_description", type="string", nullable=true)
     */
    protected $levelDescription;

    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Exam", mappedBy="examLevel")
     */
    private $exams;

    public function __construct()
    {
        $this->exams = new ArrayCollection();
    }
    
    /* Defining entity relationships */
    
    /**
     *
     * @return the $levelName
     */
    public function getLevelName()
    {
        return $this->levelName;
    }

    /**
     *
     * @return the $levelName
     */
    public function getLevelCode()
    {
        return $this->levelCode;
    }

    /**
     *
     * @return the $levelDescription
     */
    public function getLevelDescription()
    {
        return $this->levelDescription;
    }

    /**
     *
     * @param field_type $levelName            
     */
    public function setLevelName($levelName)
    {
        $this->levelName = $levelName;
        return $this;
    }

    /**
     *
     * @param field_type $levelName            
     */
    public function setLevelCode($levelCode)
    {
        $this->levelCode = $levelCode;
        return $this;
    }

    /**
     *
     * @param field_type $levelDescription            
     */
    public function setLevelDescription($levelDescription)
    {
        $this->levelDescription = $levelDescription;
        return $this;
    }
}