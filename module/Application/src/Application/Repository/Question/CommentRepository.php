<?php
namespace Application\Repository\Question;

use Base\Repository\BaseDbRepository;
use Application\Repository\Contract\Question\CommentRepositoryInterface;
use Admin\Entity\Question;
use Application\Entity\User;

class CommentRepository extends BaseDbRepository implements CommentRepositoryInterface
{
    /**
     * {@inheritDoc}
     * @see \Application\Repository\Contract\Question\CommentRepositoryInterface::getComments()
     */
    public function getComments(\Admin\Entity\Question $question)
    {
        // TODO Auto-generated method stub
        
    }

    /**
     * {@inheritDoc}
     * @see \Application\Repository\Contract\Question\CommentRepositoryInterface::getUserComments()
     */
    public function getUserComments(\Application\Entity\User $user)
    {
        // TODO Auto-generated method stub
        
    }

}