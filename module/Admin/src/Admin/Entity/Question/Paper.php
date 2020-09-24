<?php
namespace Admin\Entity\Question;

use Doctrine\ORM\Mapping as ORM;
use Base\Entity\BaseIdentityEntity;
use Admin\Entity\Contract\Question\PaperInterface as QuestionPaperInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\Question\PaperRepository")
 * @ORM\Table(name="question_papers")
 */
class Paper extends BaseIdentityEntity implements QuestionPaperInterface
{
    /* Defining entity protected member variables */
    /**
     * @ORM\Column(type="string", name="paper_name", length=100, nullable=false)
     */
    protected $paperName;
    
    /**
     * @ORM\Column(type="string", name="paper_year", length=4, nullable=false)
     */
    protected $paperYear;
    
    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Exam\Month", inversedBy = "questionPaper")
     * @ORM\JoinColumn(name="exam_mounth_id",referencedColumnName="id")
     */
    protected $examMonth;

    /**
     * @ORM\Column(type="integer", name="paper_duration", nullable=false)
     */
    protected $paperDuration;
    
    /**
     * @ORM\Column(type="text", name="paper_description", nullable=false)
     */
    protected $paperDescription;

    /**
     * @ORM\Column(type="string", name="paper_instruction", nullable=false)
     */
    protected $paperInstruction;
    
    /* Defining entity relationships */
    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Exam", inversedBy = "questionPaper")
     * @ORM\JoinColumn(name="exam_id", referencedColumnName="id")
     */
    protected $paperExam;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Subject")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     */
    protected $paperSubject;

    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Question\Section", mappedBy="sectionPaper")
     */
    protected $questionSections;

    /**
     * @return the $paperName
     */
    public function getPaperName()
    {
        return $this->paperName;
    }

	/**
     * @return the $paperDescription
     */
    public function getPaperDescription()
    {
        return $this->paperDescription;
    }

	/**
     * @return the $paperSubject
     */
    public function getPaperSubject()
    {
        return $this->paperSubject;
    }

	/**
     * @param field_type $paperName
     */
    public function setPaperName($paperName)
    {
        $this->paperName = $paperName;
        return $this;
    }

	/**
     * @param field_type $paperDescription
     */
    public function setPaperDescription($paperDescription)
    {
        $this->paperDescription = $paperDescription;
        return $this;
    }

	public function __construct()
    {
        $this->questionSections = new ArrayCollection();
    }

    /**
     *
     * @param Collection $tags            
     */
    public function addQuestionSections(Collection $questionSections)
    {
        foreach ($questionSections as $questionSection) {
            $questionSection->$questionPapers($this);
            $this->questionSections->add($questionSection);
        }
    }

    /**
     *
     * @param Collection $tags            
     */
    public function removeQuestionSections(Collection $questionSections)
    {
        foreach ($questionSections as $questionSection) {
            $questionSection->setQquestionSections(null);
            $this->questionSections->removeElement($questionSection);
        }
    }

    /**
     *
     * @return Collection
     */
    public function getQuestionSections()
    {
        return $this->questionSections;
    }

    /**
     *
     * @return the $paperExam
     */
    public function getPaperExam()
    {
        return $this->paperExam;
    }


    /**
     *
     * @return the $paperYear
     */
    public function getPaperYear()
    {
        return $this->paperYear;
    }

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
     * @return the $paperDuration
     */
    public function getPaperDuration()
    {
        return $this->paperDuration;
    }

    /**
     *
     * @return the $paperInstruction
     */
    public function getPaperInstruction()
    {
        return $this->paperInstruction;
    }

    /**
     *
     * @param field_type $paperExam            
     */
    public function setPaperExam($paperExam)
    {
        $this->paperExam = $paperExam;
        return $this;
    }

    /**
     *
     * @param field_type $paperSubject            
     */
    public function setPaperSubject($paperSubject)
    {
        $this->paperSubject = $paperSubject;
        return $this;
    }

    /**
     *
     * @param field_type $paperYear            
     */
    public function setPaperYear($paperYear)
    {
        $this->paperYear = $paperYear;
        return $this;
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

    /**
     *
     * @param field_type $paperDuration            
     */
    public function setPaperDuration($paperDuration)
    {
        $this->paperDuration = $paperDuration;
        return $this;
    }

    /**
     *
     * @param field_type $paperInstruction            
     */
    public function setPaperInstruction($paperInstruction)
    {
        $this->paperInstruction = $paperInstruction;
        return $this;
    }
}