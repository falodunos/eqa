<?php
namespace Admin\Entity\Answer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Base\Entity\BaseIdentityEntity;
use Admin\Entity\Contract\Answer\OptionInterface as AnswerOptionInterface;

/**
 * @ORM\Entity
 * @ORM\Table (name="answer_options")
 */
class Option extends BaseIdentityEntity implements AnswerOptionInterface
{

    /* Defining private member variable */
    
    /**
     * @ORM\Column(name="option_text", type="text", nullable=false)
     */
    protected $optionText;

    /**
     * @ORM\Column(type="string", name="is_correct", length=1, nullable=false, options={"default":"0"})
     */
    protected $isCorrect;

    /* Defining entity relationship */
    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Question", inversedBy="options")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    protected $question;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Question\Section")
     * @ORM\JoinColumn(name="question_section_id", referencedColumnName="id")
     */
    private $questionSection;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Question\Paper")
     * @ORM\JoinColumn(name="question_paper_id", referencedColumnName="id")
     */
    private $questionPaper;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Exam")
     * @ORM\JoinColumn(name="exam_id", referencedColumnName="id")
     */
    private $questionExam;

    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Answer\Option\Image", mappedBy="answerOption")
     */
    protected $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     *
     * @param Collection $question            
     */
    public function addImages(Collection $images)
    {
        foreach ($images as $image) {
            $image->setAnswerOption($this);
            $this->images->add($image);
        }
    }

    /**
     *
     * @param Collection $questions            
     */
    public function removeImages(Collection $images)
    {
        foreach ($images as $image) {
            $image->setAnswerOption(null);
            $this->images->removeElement($image);
        }
    }

    /**
     *
     * @return Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     *
     * @return the $questionSection
     */
    public function getQuestionSection()
    {
        return $this->questionSection;
    }

    /**
     *
     * @return the $questionPaper
     */
    public function getQuestionPaper()
    {
        return $this->questionPaper;
    }

    /**
     *
     * @return the $questionExam
     */
    public function getQuestionExam()
    {
        return $this->questionExam;
    }

    /**
     *
     * @param field_type $questionSection            
     */
    public function setQuestionSection($questionSection)
    {
        $this->questionSection = $questionSection;
        return $this;
    }

    /**
     *
     * @param field_type $questionPaper            
     */
    public function setQuestionPaper($questionPaper)
    {
        $this->questionPaper = $questionPaper;
        return $this;
    }

    /**
     *
     * @param field_type $exam            
     */
    public function setQuestionExam($questionExam)
    {
        $this->questionExam = $questionExam;
        return $this;
    }

    /* DEFINING ENTITY MEMBER FUNCTIONS */
    /**
     *
     * @return the $question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     *
     * @param field_type $question            
     */
    public function setQuestion($question)
    {
        $this->question = $question;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Admin\Entity\Contract\Answer\OptionInterface::getOptionText()
     */
    public function getOptionText()
    {
        return $this->optionText;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Admin\Entity\Contract\Answer\OptionInterface::setOptionText()
     */
    public function setOptionText($optionText)
    {
        $this->optionText = $optionText;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Admin\Entity\Contract\Answer\OptionInterface::getIsCorrect()
     */
    public function getIsCorrect()
    {
        return $this->isCorrect;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Admin\Entity\Contract\Answer\OptionInterface::setIsCorrect()
     */
    public function setIsCorrect($isCorrect)
    {
        $this->isCorrect = $isCorrect;
        return $this;
    }
}