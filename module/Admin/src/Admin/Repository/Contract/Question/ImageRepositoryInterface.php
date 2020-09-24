<?php
namespace Admin\Repository\Contract\Question;

use Base\Repository\Contract\BaseDbRepositoryInterface;

interface ImageRepositoryInterface extends BaseDbRepositoryInterface
{

    public function fetchByIsActive($imageIsActive);
}
