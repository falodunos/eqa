<?php
namespace Admin\Service\Contract\Academic;

use Admin\Entity\Contract\Academic\InstitutionInterface;

interface InstitutionServiceInterface
{

    public function findAllInstitutions();

    /**
     *
     * @param integer $id            
     */
    public function findInstitution($id);
    
    /**
     *
     * @param integer $id
     */
    public function findOneInstitutionBy(array $criteria, $orderBy = null);

    /**
     *
     * @param InstitutionInterface $institution            
     */
    public function saveInstitution($post);

    /**
     *
     * @param InstitutionInterface $institution            
     */
    public function deleteInstitution(InstitutionInterface $institution);
}