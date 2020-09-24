<?php
namespace Admin\Repository\Contract\Question;

use Base\Repository\Contract\BaseDbRepositoryInterface;

interface PaperRepositoryInterface extends BaseDbRepositoryInterface
{

    public function fetchByExamYear($examYear);

    public function fetchByIsActive($examIsActive);
}
