<?php
namespace Application\Service\Question;

use Application\Service\Contract\Question\CommentServiceInterface;
// use Admin\Repository\Question\CommentRepository ;
use Base\Service\BaseService;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Entity\Question;
use Application\Entity\User;

class CommentService extends BaseService implements CommentServiceInterface
{

    protected $_serviceLocator;

    protected $_commentRepository;

    protected $_questionRepository;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->_serviceLocator = $serviceLocator;
        $this->_commentRepository = $this->_serviceLocator->get('examsqa_application_question_comment_repository');
        $this->_questionRepository = $this->_serviceLocator->get('examsqa_admin_question_repository');
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Application\Service\Contract\Question\CommentServiceInterface::getComments()
     */
    public function getComments(Question $question)
    {
        $comments = $this->_commentRepository->findBy([
            'question' => $question
        ]);
        return $comments;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Admin\Service\Contract\Question\CommentServiceInterface::getUserComments()
     */
    public function getUserComments(User $user)
    {}

    /**
     *
     * {@inheritdoc}
     *
     * @see \Admin\Service\Contract\Question\CommentServiceInterface::addComment()
     */
    public function addComment($post)
    {
        $commentEntity = $this->_serviceLocator->get('examsqa_application_question_questioncomment_entity');
        $comment = $post['comment'];
        $question = $this->_questionRepository->find($post['questionId']);
        $dateTime = new \DateTime("now");
        
        $commentEntity->setComment($comment)
            ->setQuestion($question)
            ->setUser($this->getZfcUserIdentity())
            ->setCreatedAt($dateTime);
        
        $entity = $this->_commentRepository->insert($commentEntity);
        return $entity->getId() > 0 ? true : false;
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {
        $questionType = $this->findQuestionType($entityId);
        return array(
            [
                'id' => 'hidden',
                'value' => $questionType->getId()
            ],
            [
                'id' => 'typeName',
                'value' => $questionType->getTypeName()
            ],
            [
                'id' => 'typeDescription',
                'value' => $questionType->getTypeDescription()
            ],
            [
                'id' => 'isActive',
                'value' => $questionType->getIsActive()
            ]
        );
    }
}