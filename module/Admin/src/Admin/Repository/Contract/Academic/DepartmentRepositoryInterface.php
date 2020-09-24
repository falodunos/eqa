<?php
namespace Admin\Repository\Contract\Academic;

use Base\Repository\Contract\BaseDbRepositoryInterface;

interface DepartmentRepositoryInterface extends BaseDbRepositoryInterface
{
    public function fetchByIsActive($sectionIsActive);
}
