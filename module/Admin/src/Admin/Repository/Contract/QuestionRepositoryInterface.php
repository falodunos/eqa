<?php
namespace Admin\Repository\Contract;

use Base\Repository\Contract\BaseDbRepositoryInterface;

interface QuestionRepositoryInterface extends BaseDbRepositoryInterface
{

    public function fetchByQpaper($questionPaper);

    public function fetchByQsection($questionSection);
}