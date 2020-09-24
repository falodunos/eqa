<?php
namespace Admin\Repository\Academic;

use Base\Repository\BaseDbRepository;
use Admin\Repository\Contract\Academic\InstitutionRepositoryInterface;

class InstitutionRepository extends BaseDbRepository implements InstitutionRepositoryInterface
{
	/* (non-PHPdoc)
     * @see \Admin\Repository\Contract\Academic\InstitutionRepositoryInterface::fetchByIsActive()
     */
    public function fetchByIsActive($sectionIsActive)
    {
        
    }
}