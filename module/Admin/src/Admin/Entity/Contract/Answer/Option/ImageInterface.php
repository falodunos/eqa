<?php
namespace Admin\Entity\Contract\Answer\Option;

use Base\Entity\Contract\BaseDocumentInterface;
use Admin\Entity\Subject;
use Admin\Entity\Question\Paper as QuestionPaper;
use Admin\Entity\Question\Section as QuestionSection;
use Admin\Entity\Question;
use Admin\Entity\Answer\Option as AnswerOption;
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
    public function setPaper(QuestionPaper $paper);

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
    public function setSection(QuestionSection $section);

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
     * Get AnswerOption
     *
     * @return AnswerOption
     */
    public function getAnswerOption();

    /**
     * Set AnswerOption.
     *
     * @param AnswerOption $answerOption            
     * @return ImageInterface
     */
    public function setAnswerOption(AnswerOption $answerOption);
}