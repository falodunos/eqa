<?php
namespace Admin\Entity\Question;

use Doctrine\ORM\Mapping as ORM;
use Base\Entity\Upload\AbstractBaseDocument;
use Admin\Entity\Contract\Question\ImageInterface as QuestionImageInterface;
use Admin\Entity\Question\Section;
use Admin\Entity\Exam;
use Admin\Entity\Question;
use Admin\Entity\Subject;
/**
 * @ORM\Entity(repositoryClass="Admin\Repository\Question\ImageRepository")
 * @ORM\Table(name="question_images")
 */
class Image extends AbstractBaseDocument implements QuestionImageInterface
{

    /* DEFINING ENTITY RELATIONSHIPS */
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
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Question", inversedBy="images")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    protected $question; 
    
    /**
     *
     * @return the $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     *
     * @param field_type $images            
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Question\ImageInterface::getExam()
     */
    public function getExam()
    {
        return $this->exam;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Question\ImageInterface::getPaper()
     */
    public function getPaper()
    {
        return $this->paper;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Question\ImageInterface::getQuestion()
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Question\ImageInterface::getSection()
     */
    public function getSection()
    {
        return $this->section;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Question\ImageInterface::getSubject()
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Question\ImageInterface::setExam()
     */
    public function setExam(Exam $exam)
    {
        $this->exam = $exam;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Question\ImageInterface::setPaper()
     */
    public function setPaper(Paper $paper)
    {
        $this->paper = $paper;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Question\ImageInterface::setQuestion()
     */
    public function setQuestion(Question $question)
    {
        $this->question = $question;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Question\ImageInterface::setSection()
     */
    public function setSection(Section $section)
    {
        $this->section = $section;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Question\ImageInterface::setSubject()
     */
    public function setSubject(Subject $subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Admin\Entity\Contract\Question\ImageInterface::getAbsolutePath()
     */
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Admin\Entity\Contract\Question\ImageInterface::getWebpath()
     */
    public function getWebpath()
    {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Admin\Entity\Contract\Question\ImageInterface::getUploadRootDir()
     */
    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Admin\Entity\Contract\Question\ImageInterface::getUploadDir()
     */
    public function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }
}
