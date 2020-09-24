<?php
namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Base\Entity\BaseIdentityEntity;
use Doctrine\ORM\Mapping as ORM;
use Admin\Entity\Contract\QuestionInterface;
use Admin\Entity\Question\Section;

/**
 * @ORM\Entity
 * @ORM\Table(name="questions")
 */
class Question extends BaseIdentityEntity implements QuestionInterface
{

    /* DEFINING ENTITY MEMBER VARIABLES */
    /**
     * @ORM\Column(name ="question_text", type="text", nullable = false)
     */
    protected $questionText;

    /**
     * @ORM\Column(name ="question_tag", type="string", length = 50, nullable = false)
     */
    protected $questionTag;

    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Answer\Option", mappedBy="question")
     * @ORM\JoinColumn(name="option_id", referencedColumnName="id")
     */
    protected $options;

    /* DEFINING ENTITY RELATIONSHIP */
    
    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Question\Paper")
     * @ORM\JoinColumn(name="question_paper_id", referencedColumnName="id")
     */
    protected $questionPaper;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Question\Section", inversedBy="questions")
     * @ORM\JoinColumn(name="question_section_id", referencedColumnName="id")
     */
    protected $questionSection;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Question\Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $questionType;

    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Question\Image", mappedBy="question")
     */
    protected $images;

    public function __construct()
    {
        $this->options = new ArrayCollection();
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
     * @return the $options
     */
    public function getOptions()
    {
        return $this->options;
    }

 /**
     *
     * @param Collection $question            
     */
    public function addOptions(Collection $options)
    {
        foreach ($options as $option) {
            $option->setQuestion($this);
            $this->options->add($option);
        }
    }

    /**
     *
     * @param Collection $questions            
     */
    public function removeOptions(Collection $options)
    {
        foreach ($options as $option) {
            $option->setQuestion(null);
            $this->options->removeElement($option);
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
     * @return the $questionTag
     */
    public function getQuestionTag()
    {
        return $this->questionTag;
    }

    /**
     *
     * @param field_type $questionTag            
     */
    public function setQuestionTag($questionTag)
    {
        $this->questionTag = $questionTag;
        return $this;
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
     * @return the $questionType
     */
    public function getQuestionType()
    {
        return $this->questionType;
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
     * @param field_type $questionType            
     */
    public function setQuestionType($questionType)
    {
        $this->questionType = $questionType;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Admin\Entity\Contract\QuestionInterface::getQuestionText()
     */
    public function getQuestionText()
    {
        return $this->questionText;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Admin\Entity\Contract\QuestionInterface::setQuestionText()
     */
    public function setQuestionText($questionText)
    {
        $this->questionText = $questionText;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\QuestionInterface::getAnswer()
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\QuestionInterface::setAnswer()
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
        return $this;
    }

    /**
     *
     * @param QuestionSection $questionSection            
     */
    public function setQuestionSection(Section $questionSection = null)
    {
        $this->questionSection = $questionSection;
        return $this;
    }

    /**
     *
     * @return QuestionSection
     */
    public function getQuestionSection()
    {
        return $this->questionSection;
    }
}