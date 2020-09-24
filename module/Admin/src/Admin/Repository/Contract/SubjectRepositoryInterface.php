<?php
namespace Admin\Repository\Contract;

use Base\Repository\Contract\BaseDbRepositoryInterface;

interface SubjectRepositoryInterface extends BaseDbRepositoryInterface
{

    public function findByCode($sujectCode);

    public function fetchByIsActive($subjectIsActive);
}
