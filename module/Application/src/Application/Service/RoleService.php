<?php
namespace Application\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Entity\Contract\RoleInterface;
use Application\Service\Contract\RoleServiceInterface;

class RoleService implements RoleServiceInterface
{

    protected $_serviceLocator;
    protected $_roleRepository;
    

 public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->_serviceLocator = $serviceLocator;
        $this->_roleRepository = $this->_serviceLocator->get('examsqa_application_role_repository');
    }

    /*
     * (non-PHPdoc)
     * @see \Application\Service\Contract\RoleServiceInterface::deleteRole()
     */
    public function deleteRole(RoleInterface $role)
    {}

    /*
     * (non-PHPdoc)
     * @see \Application\Service\Contract\RoleServiceInterface::findAllRoles()
     */
    public function findAllRoles()
    {
        return $this->_roleRepository->findAll();
    }

    /*
     * (non-PHPdoc)
     * @see \Application\Service\Contract\RoleServiceInterface::findRole()
     */
    public function findRole($id)
    {
        return $this->_roleRepository->find($id);
    }
}