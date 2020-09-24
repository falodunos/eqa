<?php
namespace Admin\Entity\Question;

use Admin\Entity\Contract\Question\SectionInterface as QuestionSectionInterface;
use Admin\Entity\Question\Paper as QuestionPaper;
use Base\Entity\BaseIdentityEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author Solomon
 *         @ORM\Entity(repositoryClass="Admin\Repository\Question\SectionRepository")
 *         @ORM\Table(name="question_sections")
 *        
 */
class Section extends BaseIdentityEntity implements QuestionSectionInterface
{

    /* Defining entity protected member variables */
    /**
     * @ORM\Column(name ="section_info", type="text", nullable = false)
     */
    protected $sectionInfo;

    /**
     * @ORM\Column(type="string", name="section_name", length=100, nullable=false)
     */
    protected $sectionName;

    /**
     * @ORM\Column(type="string", name="section_description", length=255, nullable=false)
     */
    protected $sectionDescription;

    /* Defining entity relationship */
    
    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Question\Paper", inversedBy="questionSections")
     * @ORM\JoinColumn(name="section_paper_id", referencedColumnName="id")
     */
    protected $sectionPaper;

    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Question", mappedBy="questionSection")
     */
    protected $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    /**
     *
     * @param Collection $question            
     */
    public function addQuestions(Collection $questions)
    {
        foreach ($questions as $question) {
            $question->setQuestionSection($this);
            $this->questions->add($question);
        }
    }

    /**
     *
     * @param Collection $questions            
     */
    public function removeQuestions(Collection $questions)
    {
        foreach ($questions as $question) {
            $question->setQuestionSection(null);
            $this->questions->removeElement($question);
        }
    }

    /**
     *
     * @return the $sectionInfo
     */
    public function getSectionInfo()
    {
        return $this->sectionInfo;
    }

    /**
     *
     * @param field_type $sectionInfo            
     */
    public function setSectionInfo($sectionInfo)
    {
        $this->sectionInfo = $sectionInfo;
        return $this;
    }

    /**
     *
     * @return the $sectionName
     */
    public function getSectionName()
    {
        return $this->sectionName;
    }

    /**
     *
     * @return the $sectionDescription
     */
    public function getSectionDescription()
    {
        return $this->sectionDescription;
    }

    /**
     *
     * @param string $sectionName            
     */
    public function setSectionName($sectionName)
    {
        $this->sectionName = $sectionName;
        return $this;
    }

    /**
     *
     * @param string $sectionDescription            
     */
    public function setSectionDescription($sectionDescription)
    {
        $this->sectionDescription = $sectionDescription;
        return $this;
    }

    /**
     *
     * @param QuestionPaper $sectionPaper            
     */
    public function setSectionPaper($sectionPaper)
    {
        $this->sectionPaper = $sectionPaper;
        return $this;
    }

    /**
     *
     * @return SectionPaper
     */
    public function getSectionPaper()
    {
        return $this->sectionPaper;
    }

    /**
     *
     * @return Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }
}