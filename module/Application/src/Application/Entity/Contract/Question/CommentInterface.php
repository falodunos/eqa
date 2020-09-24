<?php
namespace Application\Entity\Contract\Question;

use Admin\Entity\Question;
use Application\Entity\User;

interface CommentInterface 
{
    /**
     * Get Id
     *
     * @return integer
     */
    public function getId();
    
    /**
     * Get User
     *
     * @return User
     */
    public function getUser();
    
    /**
     * Set User
     *
     * @param User $user
     * @return CommentInterface
     */
    public function setUser(User $user);
    
    /**
     * Get question
     *
     * @return Question
    */
    public function getQuestion();
    
    /**
     * Set question.
     *
     * @param Question $question
     * @return CommentInterface
    */
    public function setQuestion(Question $question);
    
    /**
     * Get comment
     *
     * @return string
     */
    public function getComment();
    
    /**
     * Set comment.
     *
     * @param string $comment
     * @return string
     */
    public function setComment($comment);
    
    /**
     * Get createdAt.
     *
     * @return datetime
     */
    public function getCreatedAt();
    
    /**
     * Set createdAt.
     *
     * @param datetime $createdAt
     * @return Comment
     */
    public function setCreatedAt($createdAt);
}