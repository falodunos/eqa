<?php
namespace Admin\Entity\Exam;

use Base\Entity\AbstractBaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Admin\Entity\Contract\Exam\MonthInterface;

/**
 *
 * @author Solomon
 *         @ORM\Entity(repositoryClass="Admin\Repository\Exam\MonthRepository")
 *         @ORM\Table (name="exam_months")
 */
class Month extends AbstractBaseEntity implements MonthInterface
{
    
    /* Defining entity protected member variables */

    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Question\Paper", mappedBy="examMonth")
     */
    protected $questionPaper;
    
    /**
     * @ORM\Column(name="exam_month", type="string", length=50, nullable=false)
     */
    protected $examMonth;

    /**
     *
     * @return the $examMonth
     */
    public function getExamMonth()
    {
        return $this->examMonth;
    }
    /**
     *
     * @param field_type $examMonth            
     */
    public function setExamMonth($examMonth)
    {
        $this->examMonth = $examMonth;
        return $this;
    }
}