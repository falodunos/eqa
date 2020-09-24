<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\JsonModel;

class PermissionController extends AbstractActionController
{

    protected $_serviceLocator;

    protected $_userIdentityService;

    protected $_institutionService;

    protected $_departmentService;

    protected $_userService;

    protected $_addUserForm;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->_serviceLocator = $serviceLocator->getServiceLocator();
        $this->_userIdentityService = $this->_serviceLocator->get('examsqa_application_user_identity_service');
        $this->_institutionService = $this->_serviceLocator->get('examsqa_admin_institution_service');
        $this->_userService = $this->_serviceLocator->get('examsqa_application_user_service');
        $this->_departmentService = $this->_serviceLocator->get('examsqa_admin_department_service');
        $this->_addUserForm = $this->_serviceLocator->get('examsqa_admin_permission_add_user_form');
    }

    public function overviewAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/permission/overview.phtml')->setTerminal(true);
            
            return $htmlViewPart;
        }
        return array();
    }

    public function usersAction()
    {
        $request = $this->getRequest();
        $htmlViewPart = new ViewModel();
        $isXmlHttpRequest = $request->isXmlHttpRequest();
        $htmlViewPart->setTerminal($isXmlHttpRequest);
        
        if ($isXmlHttpRequest) {
            $adminUser = $this->getAdminUser();
            $adminUserRoleId = $adminUser->getRoles()[0]->getRoleId();
            $users = $this->_userIdentityService->getUsers($adminUser->getId(), $adminUserRoleId);
            return $htmlViewPart->setVariable('users', $users);
        }
        return new ViewModel(array());
    }

    protected function getAdminUser()
    {
        $identity = $this->zfcUserAuthentication()->getIdentity();
        $userId = $identity->getId();
        return $this->_userService->findUser($userId);
    }

    public function adminsAction()
    {
        $request = $this->getRequest();
        $htmlViewPart = new ViewModel();
        $isXmlHttpRequest = $request->isXmlHttpRequest();
        $htmlViewPart->setTerminal($isXmlHttpRequest);
        
        if ($isXmlHttpRequest) {
            $adminUser = $this->getAdminUser();
            $userRoleId = $adminUser->getRoles()[0]->getRoleId();
            $users = $this->_userIdentityService->getUsers($adminUser->getId(), $userRoleId);
            
            return $htmlViewPart->setVariable('users', $users);
        }
        return new ViewModel(array());
    }

    public function partnersAction()
    {
        $request = $this->getRequest();
        $htmlViewPart = new ViewModel();
        $isXmlHttpRequest = $request->isXmlHttpRequest();
        $htmlViewPart->setTerminal($isXmlHttpRequest);
        
        if ($isXmlHttpRequest) {
            $adminUser = $this->getAdminUser();
            $userRoleId = $adminUser->getRoles()[0]->getRoleId();
            $partners = $this->_institutionService->getPartners($userRoleId);
            
            return $htmlViewPart->setVariable('partners', $partners);
        }
        return new ViewModel(array());
    }

    public function rolesAction()
    {
        $request = $this->getRequest();
        $htmlViewPart = new ViewModel();
        $isXmlHttpRequest = $request->isXmlHttpRequest();
        $htmlViewPart->setTerminal($isXmlHttpRequest);
        $roleService = $this->_serviceLocator->get('examsqa_application_role_service');
        
        if ($isXmlHttpRequest) {
            return $htmlViewPart->setVariable('roles', $roleService->findAllRoles());
        }
        return new ViewModel(array());
    }

    public function updateAdminStatusAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $postData = $request->getPost()->toArray();
            $updateStatus = $this->_userService->updateIsUserAdminStatus($postData);
            return new JsonModel(array(
                'status' => $updateStatus == true ? true : false
            ));
        }
    }

    public function assignDepartmentAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $adminUser = $this->getAdminUser();
            $institution = $adminUser->getIdentity()->getInstitution();
            $post = $request->getPost()->toArray();
            
            $user = $this->_userService->findUser($post['userId']);
            $department = $this->_departmentService->findDepartment($post['deptId']);
            
            $userIdentity = $this->_userIdentityService->findBy(array(
                'user' => $user
            ))[0];
            $userIdentity->setInstitution($institution)->setDepartment($department);
            
            $updateStatus = $this->_userIdentityService->updateIdentity($userIdentity);
            
            return new JsonModel(array(
                'status' => $updateStatus == true ? true : false,
                'message' => 'It is done, department had been set for this admin !'
            ));
        }
        return new JsonModel(array(
            'status' => false
        ));
    }

    public function addUserAction()
    {
        $request = $this->getRequest();
        
        $htmlViewPart = new ViewModel();
        $htmlViewPart->setTerminal($request->isXmlHttpRequest());
        $addUserForm = $this->_serviceLocator->get('examsqa_admin_permission_add_user_form');
        
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost();
            $form = $this->_addUserForm->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();
                $token = $data['token'];
                $userIdentity = $this->_userIdentityService->findBy(array(
                    'token' => $token
                ));
                
                if (count($userIdentity) > 0) {
                    $institution = $userIdentity[0]->getInstitution();
                    $department = $userIdentity[0]->getDepartment();
                    
                    if (!is_null($institution) && is_null($department)){
                        return new JsonModel(array(
                            'status' => false,
                            'message' => 'Changes was not effected because this user is associated with an institution already !'
                        ));
                    }
                    
                    $adminUser = $this->getAdminUser();
                    $status = $this->_userIdentityService->addUser($data, $adminUser, $userIdentity[0]);
                    
                    return new JsonModel(array(
                        'status' => $status,
                        'message' => $status == true ? 'It is done, please activate admin status on this account !' : 'Unable to complete requested operation, please try again later!'
                    ));
                }
                
                return new JsonModel(array(
                    'status' => false,
                    'message' => 'A user with the specified token was not found, please check your speeling and try again !'
                ));
            } else {
                return new JsonModel(array(
                    'status' => false,
                    'message' => 'Invalid data detected, please try again later !'
                ));
            }
        }
        
        return $htmlViewPart->setVariable('addUserForm', $addUserForm);
    }
}