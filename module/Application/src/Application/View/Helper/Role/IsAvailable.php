<?php
namespace Application\View\Helper\Role;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorInterface;

class IsAvailable extends AbstractHelper
{

    protected $_serviceLocator;

    public function __construct(ServiceLocatorInterface $serviceLocator = null)
    {
        $this->_serviceLocator = $serviceLocator;
    }

    public function __invoke($identity, $roleId)
    {
        if (! is_null($identity)) {
            foreach ($identity->getRoles() as $role) {
                if ($role->getRoleId() == $roleId) {
                    return true;
                }
            }
        }
        return false;
    }
}