<?php
namespace Admin\Repository\Contract;

use Base\Repository\Contract\BaseDbRepositoryInterface;

interface ExamRepositoryInterface extends BaseDbRepositoryInterface
{

    public function findByCode($examCode);

    public function getByLevel($examLevel);

    public function getByYear($examYear);

    public function getByType($examType);

    public function getByCertificate($examCertificate);

    public function getByIsActive($examIsActive);
}
