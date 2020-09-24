<?php
namespace Application\Service\User;

use Application\Service\Contract\User\IdentityInterface as UserIdentityInterface;
use Application\Repository\Contract\User\IdentityRepositoryInterface as UserIdentityRepositoryInterface;
use Application\Entity\Contract\UserInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Service\Generator\Strings\AdapterAbstract as StringGeneratorAdapter;
use Base\Service\BaseService;

class IdentityService extends BaseService implements UserIdentityInterface
{

    protected $_userIdentityRepository;

    protected $_departmentRepository;

    protected $_serviceLocator;

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {}

    public function __construct(ServiceLocatorInterface $serviceLocator, UserIdentityRepositoryInterface $userIdentityRepository)
    {
        $this->_userIdentityRepository = $userIdentityRepository;
        $this->_serviceLocator = $serviceLocator;
        $this->_departmentRepository = $this->_serviceLocator->get('examsqa_admin_department_repository');
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\Contract\BaseServiceInterface::findBy()
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->_userIdentityRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    protected function getStringGenerator()
    {
        return $this->_serviceLocator->get('examsqa_application_string_generator_service');
    }

    public function generateTokenAndLogUserIdentity(UserInterface $user)
    {
        $stringGenerator = $this->getStringGenerator();
        $isExisting = true;
        do {
            $generatedToken = $stringGenerator->generate(StringGeneratorAdapter::GEN_STRING_UCASE);
            $isExisting = $this->isExisting($generatedToken);
            $isExisting == false ? $this->saveIdentity($user, $generatedToken) : '';
        } while ($isExisting == true);
    }

    protected function isExisting($generatedToken)
    {
        $token = $this->_userIdentityRepository->findBy(array(
            'token' => $generatedToken
        ));
        return count($token) == 1 ? true : false;
    }

    protected function saveIdentity($user, $generatedToken)
    {
        $identity = $this->_serviceLocator->get('examsqa_application_user_identity_entity');
        $dateTime = new \DateTime("now");
        $identity->setUser($user)
            ->setToken($generatedToken)
            ->setIsActive(1)
            ->setCreatedAt($dateTime)
            ->setUpdatedAt($dateTime);
        $this->_userIdentityRepository->insert($identity);
    }

    public function updateIdentity($identity)
    {
        return $this->_userIdentityRepository->update($identity)->getId() ? true : false;
    }

    public function getUsers($userId, $userRoleId)
    {
        $userService = $this->_serviceLocator->get('examsqa_application_user_service');
        $user = $userService->findUser($userId);
        $users = '';
        
        switch ($userRoleId) {
            case 'root-admin':
                $users = $userService->findAllUsers();
                break;
            case 'super-admin':
                $users = $this->getIdentityInstitutionUsers($user);
                break;
            case 'operation-admin': 
                $users = $this->getIdentityInstitutionDepartmentUsers($user);
                break;
            default:
                $users = [];
        }
        return $users;
    }

    public function getAdminUsers($userId, $userRoleId)
    {
        $userService = $this->_serviceLocator->get('examsqa_application_user_service');
        $user = $userService->findUser($userId);
        $users = '';
        
        switch ($userRoleId) {
            case 'root-admin':
                $users = $userService->findAllUsers();
                break;
            case 'super-admin':
                $users = $this->getIdentityInstitutionUsers($user);
                break;
            case 'operation-admin':
                $users = $this->getIdentityInstitutionDepartmentUsers($user);
                break;
            default:
                $users = [];
        }
        return $users;
    }

    protected function getIdentityInstitutionUsers($user)
    {
        $users = [];
        $identities = $this->findBy(array(
            'institution' => $user->getInstitution()
        ));
        foreach ($identities as $identity) {
            $users[] = $identity->getUser();
        }
        return $users;
    }
    
    public function findUserIdentityBy(array $criteria){
        return $this->_userIdentityRepository->findBy($criteria);
    }
    
    protected function getIdentityInstitutionDepartmentUsers($user)
    {
        $users = [];
        $institution = $user->getIdentity()->getInstitution(); 
        $department = $user->getIdentity()->getDepartment();
        $identities = $this->findUserIdentityBy(array('institution' => $institution, 'department' => $department));

        foreach ($identities as $identity) {
            $users[] = $identity->getUser();
        }
        
        return $users;
    }

    public function addUser($data, $adminUser, $userIdentity)
    {
        $adminRoleId = $adminUser->getRoles()[0]->getRoleId();
        if ($adminRoleId == 'operation-admin') {
            
            $userIdentity->setInstitution($adminUser->getInstitution())
                ->setDepartment($adminUser->getDepartment());
            
            return (int) $this->_userIdentityRepository->update($userIdentity)->getId() > 0 ? true : false;
        } elseif ($adminRoleId == 'super-admin') {
            
            $deptId = $data['department'];
            $department = $this->_departmentRepository->find($deptId);
            $userIdentity->setInstitution($adminUser->getInstitution())
                ->setDepartment($department);
            
            return (int) $this->_userIdentityRepository->update($userIdentity)->getId() > 0 ? true : false;
        } else;
    }
}