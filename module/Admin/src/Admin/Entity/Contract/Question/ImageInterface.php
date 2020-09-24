<?php
namespace Admin\Entity\Contract\Question;

use Base\Entity\Contract\BaseDocumentInterface;
use Admin\Entity\Subject;
use Admin\Entity\Question\Paper;
use Admin\Entity\Question\Section;
use Admin\Entity\Question;
use Admin\Entity\Exam;

interface ImageInterface extends BaseDocumentInterface
{
    /**
     * Get Exam
     *
     * @return Exam
     */
    public function getExam();
    
    /**
     * Set Exam.
     *
     * @param Exam $exam
     * @return ImageInterface
    */
    public function setExam(Exam $exam);
    
    /**
     * Get subject
     *
     * @return Subject
    */
    public function getSubject();
    
    /**
     * Set subject.
     *
     * @param Subject $subject
     * @return ImageInterface
    */
    public function setSubject(Subject $subject);
    
    /**
     * Get Paper
     *
     * @return Paper
    */
    public function getPaper();
    
    /**
     * Set Paper.
     *
     * @param Paper $paper
     * @return ImageInterface
    */
    public function setPaper(Paper $paper);
    
    /**
     * Get Section
     *
     * @return Section
    */
    public function getSection();
    
    /**
     * Set Section.
     *
     * @param Section $section
     * @return ImageInterface
    */
    public function setSection(Section $section);
    
    /**
     * Get Question
     *
     * @return Question
    */
    public function getQuestion();
    
    /**
     * Set Question.
     *
     * @param Question $question
     * @return ImageInterface
    */
    public function setQuestion(Question $question);
    
    /**
     * Get AbsolutePath.
     *
     * @return string
     */
    public function getAbsolutePath();
    
    /**
     * Get WebPath.
     *
     * @return string
     */
    public function getWebpath();
    
    /**
     * Get UploadRootDir.
     *
     * @return string
     */
    public function getUploadRootDir();
    
    /**
     * Get UploadDir.
     *
     * @return string
     */
    public function getUploadDir();
}