<?php
namespace Application\Service\Contract\Question;

use Admin\Entity\Question;
use Application\Entity\User;

interface CommentServiceInterface
{

    public function getComments(Question $question);

    public function getUserComments(User $user);
    
    public function addComment($post);
}