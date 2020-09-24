<?php
namespace Admin\Repository\Contract\Academic;

use Base\Repository\Contract\BaseDbRepositoryInterface;

interface InstitutionRepositoryInterface extends BaseDbRepositoryInterface
{
    public function fetchByIsActive($sectionIsActive);
}
