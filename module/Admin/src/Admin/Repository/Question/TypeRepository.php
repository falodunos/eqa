<?php
namespace Admin\Repository\Question;

use Base\Repository\BaseDbRepository;
use Admin\Repository\Contract\Question\TypeRepositoryInterface as QuestionTypeRepositoryInterface;

class TypeRepository extends BaseDbRepository implements QuestionTypeRepositoryInterface
{
	/* (non-PHPdoc)
     * @see \Admin\Repository\Contract\Question\TypeRepositoryInterface::fetchByIsActive()
     */
    public function fetchByIsActive($sectionIsActive)
    {
        
    }
}