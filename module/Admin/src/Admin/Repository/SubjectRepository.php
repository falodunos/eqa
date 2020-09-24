<?php
namespace Admin\Repository;

use Base\Repository\BaseDbRepository;
use Admin\Repository\Contract\SubjectRepositoryInterface;
// use Doctrine\ORM\EntityManager;

class SubjectRepository extends BaseDbRepository implements SubjectRepositoryInterface
{

    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\SubjectRepositoryInterface::findByCode()
     */
    public function findByCode($sujectCode)
    {
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\SubjectRepositoryInterface::fetchByIsActive()
     */
    public function fetchByIsActive($subjectIsActive)
    {
        // TODO Auto-generated method stub
    }
}