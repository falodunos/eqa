<?php
namespace Admin\Entity;

use Admin\Entity\Contract\ExamInterface;
use Admin\Entity\Exam\Certificate;
use Admin\Entity\Exam\Level;
use Base\Entity\BaseIdentityEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of Exam
 *
 * @author Solomon
 *         @ORM\Entity(repositoryClass="Admin\Repository\ExamRepository")
 *         @ORM\Table(name="exams")
 */
class Exam extends BaseIdentityEntity implements ExamInterface
{
    /* Defining entity protected member variables */
    
    /**
     * @ORM\Column(type="string", name="exam_name", length=100, nullable=false)
     */
    protected $examName;

    /**
     * @ORM\Column(type="datetime", name="date_established", nullable=false)
     */
    protected $dateEstablished;

    /**
     * @ORM\Column(type="string", name="exam_code", length=25, nullable=false)
     */
    protected $examCode;

    /**
     * @ORM\Column(type="string", name="exam_description", length=255, nullable=true)
     */
    protected $examDescription;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Exam\Certificate", inversedBy="exams")
     * @ORM\JoinColumn(name="certificate_id", referencedColumnName="id")
     */
    protected $examCertificate;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Exam\Level", inversedBy="exams")
     * @ORM\JoinColumn(name="level_id", referencedColumnName="id")
     */
    protected $examLevel;
    
    /* Defining entity relationships */
    /**
     * @ORM\ManyToMany(targetEntity="Admin\Entity\Subject", inversedBy="exams")
     * @ORM\JoinColumn(referencedColumnName="id")
     * @ORM\JoinTable(name="exams_subjects_join")
     */
    protected $subjects;
    
    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Question\Paper", mappedBy="paperExam")
     */
    private $questionPaper;

    /**
     * @return the $examCertificate
     */
    public function getExamCertificate()
    {
        return $this->examCertificate;
    }

	/**
     * @param field_type $examCertificate
     */
    public function setExamCertificate(Certificate $examCertificate = null)
    {
        $this->examCertificate = $examCertificate;
        return $this;
    }

	public function __construct()
    {
        $this->subjects = new ArrayCollection();
    }

    /**
     *
     * @param Collection $subjects            
     */
    public function addSubjects(Collection $subjects)
    {
        foreach ($subjects as $subject) {
            $this->subjects->add($subject);
        }
    }

    /**
     *
     * @return Collection
     */
    public function getSubjects()
    {
        return $this->subjects;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\ExamInterface::getExamName()
     */
    public function getExamName()
    {
        return $this->examName;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\ExamInterface::setExamName()
     */
    public function setExamName($examName)
    {
        $this->examName = $examName;
        return $this;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\ExamInterface::getDateEstablished()
     */
    public function getDateEstablished()
    {
        return $this->dateEstablished;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\ExamInterface::setDateEstablished()
     */
    public function setDateEstablished($dateEstablished)
    {
        $this->dateEstablished = $dateEstablished;
        return $this;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\ExamInterface::getExamCode()
     */
    public function getExamCode()
    {
        return $this->examCode;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\ExamInterface::setExamCode()
     */
    public function setExamCode($examCode)
    {
        $this->examCode = $examCode;
        return $this;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\ExamInterface::getExamLevel()
     */
    public function getExamLevel()
    {
        return $this->examLevel;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\ExamInterface::setExamlevel()
     */
    public function setExamlevel(Level $examLevel = null)
    {
        $this->examLevel = $examLevel;
        return $this;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\ExamInterface::getExamDescription()
     */
    public function getExamDescription()
    {
        return $this->examDescription;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\ExamInterface::setExamDescription()
     */
    public function setExamDescription($examDescription)
    {
        $this->examDescription = $examDescription;
        return $this;
    }

}