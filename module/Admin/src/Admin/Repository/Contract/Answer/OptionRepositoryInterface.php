<?php
namespace Admin\Repository\Contract\Answer;

use Base\Repository\Contract\BaseDbRepositoryInterface;

interface OptionRepositoryInterface extends BaseDbRepositoryInterface
{

    public function findeByIsActive($optionIsActive);

    public function findByQuestion($question);
}
