<?php
namespace Admin\Repository\Contract\Question;

use Base\Repository\Contract\BaseDbRepositoryInterface;

interface TypeRepositoryInterface extends BaseDbRepositoryInterface
{

    public function fetchByIsActive($sectionIsActive);
}
