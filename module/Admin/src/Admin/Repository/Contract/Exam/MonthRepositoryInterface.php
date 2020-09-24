<?php
namespace Admin\Repository\Contract\Exam;

use Base\Repository\Contract\BaseDbRepositoryInterface;

interface MonthRepositoryInterface extends BaseDbRepositoryInterface
{

    public function fetchByIsActive($examMonthIsActive);
}
