<?php
namespace Application\Service\Contract;

use Application\Entity\Contract\UserInterface;
use Base\Service\Contract\BaseServiceInterface;

interface UserServiceInterface extends BaseServiceInterface
{

    public function findAllUsers();

    /**
     *
     * @param unknown $id            
     */
    public function findUser($id);

    /**
     *
     * @param PostInterface $user            
     */
    public function deleteUser(UserInterface $user);
}