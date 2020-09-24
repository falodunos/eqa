<?php
namespace Admin\Entity;

// use Admin\Entity\Exam\Exam;
use Base\Entity\BaseIdentityEntity;
use Admin\Entity\Question;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Admin\Entity\Contract\SubjectInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="subjects")
 */
class Subject extends BaseIdentityEntity implements SubjectInterface
{
    /* Defining entity protected member variables */

    /**
     * @ORM\Column(type="string", name="subject_name", length=100, nullable=false)
     */
    protected $subjectName;

    /**
     * @ORM\Column(type="string", name="subject_code", length=20, nullable=false)
     */
    protected $subjectCode;

    /**
     * @ORM\Column(type="string", name="subject_description", length=255, nullable=false)
     */
    protected $subjectDescription;
    
    /* Defining entity relationships */
    /**
     * @ORM\ManyToMany(targetEntity="Admin\Entity\Exam", mappedBy="subjects")
     * @ORM\JoinColumn(referencedColumnName="id")
     * @ORM\OrderBy({"examName"="ASC"})
     */
    protected $exams;

	/* DEFINING ENTITY MEMBER FUNCTION */
    public function __construct()
    {
        $this->exams = new ArrayCollection();
        $this->questions = new ArrayCollection();
    }

    /**
     * @param Collection $exams
     */
    public function addExams(Collection $exams)
    {
        foreach ($exams as $exam) {
            $exam->addSubjects($this);
            $this->exams->add($exam);
        }
    }
    
    /**
     * @param Collection $exams
     */
    public function removeExams(Collection $exams)
    {
        foreach ($exams as $exam) {
            $exam->addSubjects(null);
            $this->exams->removeElement($exam);
        }
    }
       
    /**
     * Add the subject to an Question
     *
     * @param Question $question            
     * @return void
     */
    public function addToQuestion(Question $question)
    {
        $question->addSubject($this);
        $this->questions[] = $question;
    }

    /**
     *
     * @return the $subjectName
     */
    public function getSubjectName()
    {
        return $this->subjectName;
    }

    /**
     *
     * @param field_type $subjectName            
     * @return $this
     */
    public function setSubjectName($subjectName)
    {
        $this->subjectName = $subjectName;
        return $this;
    }

    /**
     *
     * @return the $subjectCode
     */
    public function getSubjectCode()
    {
        return $this->subjectCode;
    }

    /**
     *
     * @param field_type $subjectCode            
     * @return $this
     */
    public function setSubjectCode($subjectCode)
    {
        $this->subjectCode = $subjectCode;
        return $this;
    }

    /**
     *
     * @return the $subjectDescription
     */
    public function getSubjectDescription()
    {
        return $this->subjectDescription;
    }

    /**
     *
     * @param field_type $subjectDescription            
     * @return $this
     */
    public function setSubjectDescription($subjectDescription)
    {
        $this->subjectDescription = $subjectDescription;
        return $this;
    }

    /**
     *
     * @return Collection
     */
    public function getExams()
    {
        return $this->exams;
    }
}