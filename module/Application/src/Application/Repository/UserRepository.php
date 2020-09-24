<?php
namespace Application\Repository;

use Application\Repository\Contract\UserRepositoryInterface;
use Base\Repository\BaseDbRepository;

class UserRepository extends BaseDbRepository implements UserRepositoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \ZfcUser\Mapper\UserInterface::findByEmail()
     */
    public function findByEmail($email)
    {
        $er = $this->_em->getRepository($this->getEntityClass());
        
        return $er->findOneBy(array(
            'email' => $email
        ));
    }

    /*
     * (non-PHPdoc)
     * @see \ZfcUser\Mapper\UserInterface::findByUsername()
     */
    public function findByUsername($username)
    {
        $er = $this->_em->getRepository($this->getEntityClass());
        
        return $er->findOneBy(array(
            'username' => $username
        ));
    }
}