<?php
namespace Application\Service\Contract;

use Application\Entity\Contract\RoleInterface;
use Base\Service\Contract\BaseServiceInterface;

interface RoleServiceInterface extends BaseServiceInterface
{

    public function findAllRoles();

    /**
     *
     * @param unknown $id            
     */
    public function findRole($id);

    /**
     *
     * @param PostInterface $user            
     */
    public function deleteRole(RoleInterface $role);
}