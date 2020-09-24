<?php
namespace Admin\Entity\Answer\Option;

use Doctrine\ORM\Mapping as ORM;
use Base\Entity\Upload\AbstractBaseDocument;
use Admin\Entity\Contract\Answer\Option\ImageInterface as AnswerOptionImageInterface;
use Admin\Entity\Answer\Option;
use Admin\Entity\Exam;
use Admin\Entity\Question\Paper as QuestionPaper;
use Admin\Entity\Question;
use Admin\Entity\Question\Section as QuestionSection;
use Admin\Entity\Subject;

/**
 * @ORM\Entity
 * @ORM\Table (name="answer_option_image")
 */
class Image extends AbstractBaseDocument implements AnswerOptionImageInterface
{

    /* Defining entity relationship */
    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Exam")
     * @ORM\JoinColumn(name="exam_id", referencedColumnName="id")
     */
    protected $exam;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Subject")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     */
    protected $subject;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Question\Paper")
     * @ORM\JoinColumn(name="question_paper_id", referencedColumnName="id")
     */
    protected $paper;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Question\Section")
     * @ORM\JoinColumn(name="question_section_id", referencedColumnName="id")
     */
    protected $section;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Question")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    protected $question;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Answer\Option", inversedBy="images")
     * @ORM\JoinColumn(name="answer_option_id", referencedColumnName="id")
     */
    protected $answerOption;

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Answer\Option\ImageInterface::getAnswerOption()
     */
    public function getAnswerOption()
    {
        return $this->answerOption;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Answer\Option\ImageInterface::getExam()
     */
    public function getExam()
    {
        return $this->exam;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Answer\Option\ImageInterface::getPaper()
     */
    public function getPaper()
    {
        return $this->paper;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Answer\Option\ImageInterface::getQuestion()
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Answer\Option\ImageInterface::getSection()
     */
    public function getSection()
    {
        return $this->section;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Answer\Option\ImageInterface::getSubject()
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Answer\Option\ImageInterface::setAnswerOption()
     */
    public function setAnswerOption(Option $answerOption)
    {
        $this->answerOption = $answerOption;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Answer\Option\ImageInterface::setExam()
     */
    public function setExam(Exam $exam)
    {
        $this->exam = $exam;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Answer\Option\ImageInterface::setPaper()
     */
    public function setPaper(QuestionPaper $paper)
    {
        $this->paper = $paper;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Answer\Option\ImageInterface::setQuestion()
     */
    public function setQuestion(Question $question)
    {
        $this->question = $question;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Answer\Option\ImageInterface::setSection()
     */
    public function setSection(QuestionSection $section)
    {
        $this->section = $section;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Answer\Option\ImageInterface::setSubject()
     */
    public function setSubject(Subject $subject)
    {
        $this->subject = $subject;
        return $this;
    }
}