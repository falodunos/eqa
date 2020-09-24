<?php
namespace Application\Service;

use ZfcUser\Service\User as ZfcUserService;
use Application\Service\Contract\User\IdentityInterface as UserIdentityInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Service\Contract\UserServiceInterface;
use Application\Entity\Contract\UserInterface;

class UserService extends ZfcUserService implements UserServiceInterface
{

    protected $_userIdentity;

    protected $_serviceLocator;

    protected $_userRepository;

    public function __construct(UserIdentityInterface $userIdentity, ServiceLocatorInterface $serviceLocator)
    {
        $this->_userIdentity = $userIdentity;
        $this->_serviceLocator = $serviceLocator;
        $this->_userRepository = $this->_serviceLocator->get('examsqa_application_user_repository');
    }

    public function getUserIdentityService()
    {
        return $this->_userIdentity;
    }

    public function generateTokenAndLogUserIdentity(UserInterface $user)
    {
        $this->_userIdentity->generateTokenAndLogUserIdentity($user);
    }

    /*
     * (non-PHPdoc)
     * @see \Application\Service\Contract\UserServiceInterface::deleteUser()
     */
    public function deleteUser(UserInterface $user)
    {}

    /*
     * (non-PHPdoc)
     * @see \Application\Service\Contract\UserServiceInterface::findAllUsers()
     */
    public function findAllUsers()
    {
        return $this->_userRepository->findAll();
    }

    /*
     * (non-PHPdoc)
     * @see \Application\Service\Contract\UserServiceInterface::findUser()
     */
    public function findUser($id)
    {
        return $this->_userRepository->find($id);
    }

    /*
     * (non-PHPdoc)
     * @see \Application\Service\Contract\UserServiceInterface::findBy()
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->_userRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function updateIsUserAdminStatus($post)
    {
        $auth = $this->getAuthService();
        $zfcUserIdentity = $auth->getIdentity();
        $adminRoleId = $zfcUserIdentity->getRoles()[0]->getRoleId();
        
        $user = $this->_userRepository->find($post['entity_id']);
        
        if ($adminRoleId == 'root-admin') {
            
            $institution = $this->_serviceLocator->get('examsqa_admin_institution_service')->findOneInstitutionBy(array(
                'user' => $user
            ));
            if (! is_null($user->getIdentity()) && ! is_null($institution)) {
                $user->setIsAdmin($post['value'])
                    ->getIdentity()
                    ->setInstitution($institution);
                $user = $this->deleteExistingUserRoles($user);
                $user->addRole($this->getRole('super_admin_user_role'));
                return $this->_userRepository->update($user)->getId() ? true : false;
            }
        } elseif (($adminRoleId == 'super-admin') || ($adminRoleId == 'operation-admin')) {
            
            $institution = $zfcUserIdentity->getIdentity()->getInstitution();
            $user->setIsAdmin($post['value'])
                ->getIdentity()
                ->setInstitution($institution);
            
            $user = $this->deleteExistingUserRoles($user);
            
            $adminRoleId == 'super-admin' ? $user->addRole($this->getRole('operation_admin_user_role')) : '';
            $adminRoleId == 'operation-admin' ? $user->addRole($this->getRole('admin_user_role')) : '';
            
            return $this->_userRepository->update($user)->getId() ? true : false;
        }
        
        return false;
    }
    
    protected function deleteExistingUserRoles($user){
        $roles = $user->getRoles();
        $user->removeRoles($roles);
        return  $this->_userRepository->update($user);
    }
    
    protected function getRole($roleId)
    {
        $em = $this->_serviceLocator->get('doctrine.entitymanager.orm_default');
        $config = $this->_serviceLocator->get('config');
        $criteria = array(
            'roleId' => $config['zfcuser'][$roleId]
        );
        $userRole = $em->getRepository('Application\Entity\Role')->findOneBy($criteria);
        return $userRole;
    }
    
    public function editProfile($post){
        $id = $post['user-profile-fieldset']['id'];
        $form = $this->getServiceManager()->get('examsqa_application_user_profile_form');
        
        $dateTime = new \DateTime("now");
        
        if ($id) { // updating existing level entity ...
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setUpdatedAt($dateTime);
                return $this->_userRepository->update($entity)->getId() ? true : false; // save modified entity
            }
        }
    }
}