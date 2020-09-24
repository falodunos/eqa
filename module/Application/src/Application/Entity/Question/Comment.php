<?php
namespace Application\Entity\Question;

use Doctrine\ORM\Mapping as ORM;
// use Admin\Entity\Contract\Question\ImageInterface as QuestionImageInterface;
use Admin\Entity\Question;
use Application\Entity\Contract\Question\CommentInterface;
use Application\Entity\User;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\Question\CommentRepository")
 * @ORM\Table(name="question_comments")
 */
class Comment implements CommentInterface
{

    /* DEFINING ENTITY RELATIONSHIPS */
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Question")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    protected $question;

    /**
     * @ORM\Column(type="text", name="comment", nullable=false)
     */
    protected $comment;

    /**
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     */
    protected $createdAt;

    /**
     *
     * @see \Base\Entity\Contract\BaseEntityInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *
     * @param \DateTime $createdAt            
     * @return \Base\Entity\AbstractBaseEntity
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Admin\Entity\Contract\Question\CommentInterface::getUser()
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Admin\Entity\Contract\Question\CommentInterface::setUser()
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Admin\Entity\Contract\Question\CommentInterface::getQuestion()
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Admin\Entity\Contract\Question\CommentInterface::setQuestion()
     */
    public function setQuestion(Question $question)
    {
        $this->question = $question;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Admin\Entity\Contract\Question\CommentInterface::getComment()
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Admin\Entity\Contract\Question\CommentInterface::setComment()
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }
}