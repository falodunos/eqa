<?php
namespace Application\Repository\Contract\Question;

use Base\Repository\Contract\BaseDbRepositoryInterface;
use Admin\Entity\Question;
use Application\Entity\User;

interface CommentRepositoryInterface extends BaseDbRepositoryInterface
{

    public function getComments(Question $question);

    public function getUserComments(User $user);
}