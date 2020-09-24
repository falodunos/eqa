<?php
namespace Admin\Repository\Contract\Question;

use Base\Repository\Contract\BaseDbRepositoryInterface;

interface SectionRepositoryInterface extends BaseDbRepositoryInterface
{

    public function fetchByExam($exam);

    public function fetchBySubject($subject);

    public function fetchByIsActive($sectionIsActive);
}
