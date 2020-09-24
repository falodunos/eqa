<?php
namespace Application\Controller;

use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\Stdlib\Parameters;
use Zend\View\Model\ViewModel;
use ZfcUser\Service\User as UserService;
use ZfcUser\Options\UserControllerOptionsInterface;

class UserController extends AbstractActionController
{

    const ROUTE_CHANGEPASSWD = 'zfcuser/changepassword';

    const ROUTE_LOGIN = 'zfcuser/login';

    const ROUTE_REGISTER = 'zfcuser/register';

    const ROUTE_CHANGEEMAIL = 'zfcuser/changeemail';

    const CONTROLLER_NAME = 'zfcuser';

    /**
     *
     * @var UserService
     */
    protected $userService;

    /**
     *
     * @var Form
     */
    protected $loginForm;

    /**
     *
     * @var Form
     */
    protected $registerForm;

    /**
     *
     * @var Form
     */
    protected $changePasswordForm;

    /**
     *
     * @var Form
     */
    protected $changeEmailForm;

    /**
     *
     * @todo Make this dynamic / translation-friendly
     * @var string
     */
    protected $failedLoginMessage = 'Authentication failed. Please try again.';

    /**
     *
     * @var UserControllerOptionsInterface
     */
    protected $options;

    /**
     *
     * @var callable $redirectCallback
     */
    protected $redirectCallback;

    protected $_examsqaSession;

    /**
     *
     * @param callable $redirectCallback            
     */
    public function __construct($redirectCallback)
    {
        if (! is_callable($redirectCallback)) {
            throw new \InvalidArgumentException('You must supply a callable redirectCallback');
        }
        $this->redirectCallback = $redirectCallback;
    }

    /**
     * User page
     */
    public function indexAction()
    {
        if (! $this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }
        $this->_examsqaSession = $this->getServiceLocator()->get('examsqa_session');
        
        $request = $this->getRequest();
        $institutionService = $this->getServiceLocator()->get('examsqa_admin_institution_service');
        $subjectService = $this->getServiceLocator()->get('examsqa_admin_subject_service');
        
        if ($request->isPost()) {
            $instId = $request->getPost()->toArray()['featuredSubjectsInstId'];
            $this->_examsqaSession->featuredSubjectsInstId = $instId;
            $institution = $institutionService->findInstitution($instId);
            $criteria = [
                'institution' => $institution
            ];
            $subjects = $subjectService->findSubjectBy($criteria);
        } else {
            if (! $this->_examsqaSession->featuredSubjectsInstId) {
                $this->_examsqaSession->featuredSubjectsInstId = 1;
            }
            
            $institution = $institutionService->findInstitution($this->_examsqaSession->featuredSubjectsInstId);
            $criteria = [
                'institution' => $institution
            ];
            $subjects = $subjectService->findSubjectBy($criteria);
        }
        
        $institutions = $institutionService->findAllInstitutions();
        return new ViewModel([
            'subjects' => $subjects,
            'institutions' => $institutions,
            'examsqaSession' => $this->_examsqaSession
        ]);
    }

    /**
     * Login form
     */
    public function loginAction()
    {
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute($this->getOptions()
                ->getLoginRedirectRoute());
        }
        
        $request = $this->getRequest();
        $form = $this->getLoginForm();
        
        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $request->getQuery()->get('redirect')) {
            $redirect = $request->getQuery()->get('redirect');
        } else {
            $redirect = false;
        }
        
        if (! $request->isPost()) {
            return $this->redirect()->toRoute('home'); // return to home page
            return array(
                'loginForm' => $form,
                'redirect' => $redirect,
                'enableRegistration' => $this->getOptions()->getEnableRegistration()
            );
        }
        
        $form->setData($request->getPost());
        
        if (! $form->isValid()) {
            $this->flashMessenger()
                ->setNamespace('zfcuser-login-form')
                ->addMessage($this->failedLoginMessage);
            return $this->redirect()->toUrl($this->url()
                ->fromRoute(static::ROUTE_LOGIN) . ($redirect ? '?redirect=' . rawurlencode($redirect) : ''));
        }
        
        // clear adapters
        $this->zfcUserAuthentication()
            ->getAuthAdapter()
            ->resetAdapters();
        $this->zfcUserAuthentication()
            ->getAuthService()
            ->clearIdentity();
        
        $rememberMe = $request->getPost()->toArray()['rememberMe'];
        return $this->forward()->dispatch(static::CONTROLLER_NAME, array(
            'action' => 'authenticate',
            'rememberMe' => $rememberMe
        ));
    }

    /**
     * Logout and clear the identity
     */
    public function logoutAction()
    {
        $this->zfcUserAuthentication()
            ->getAuthAdapter()
            ->resetAdapters();
        $this->zfcUserAuthentication()
            ->getAuthAdapter()
            ->logoutAdapters();
        $this->zfcUserAuthentication()
            ->getAuthService()
            ->clearIdentity();
        
        $redirect = $this->redirectCallback;
        
        return $redirect();
    }

    /**
     * General-purpose authentication action
     */
    public function authenticateAction()
    {
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute($this->getOptions()
                ->getLoginRedirectRoute());
        }
        
        $adapter = $this->zfcUserAuthentication()->getAuthAdapter();
        $redirect = $this->params()->fromPost('redirect', $this->params()
            ->fromQuery('redirect', false));
        
        $result = $adapter->prepareForAuthentication($this->getRequest());
        
        // Return early if an adapter returned a response
        if ($result instanceof Response) {
            return $result;
        }
        
        $auth = $this->zfcUserAuthentication()
            ->getAuthService()
            ->authenticate($adapter);
        
        if (! $auth->isValid()) {
            $this->flashMessenger()
                ->setNamespace('zfcuser-login-form')
                ->addMessage($this->failedLoginMessage);
            $adapter->resetAdapters();
            return $this->redirect()->toUrl($this->url()
                ->fromRoute(static::ROUTE_LOGIN) . ($redirect ? '?redirect=' . rawurlencode($redirect) : ''));
        }
        $rememberMe = $this->getEvent()
            ->getRouteMatch()
            ->getParam('rememberMe');
        (int) $rememberMe == 1 ? $this->rememberUserIdentity($auth, $rememberMe) : '';
        
        $redirect = $this->redirectCallback;
        
        return $redirect();
    }

    protected function rememberUserIdentity($auth, $rememberMe)
    {
        $sessionStorage = $this->getServiceLocator()->get('examsqa_application_zend_session');
        $sessionStorage->setRememberMe($rememberMe);
        // set storage again
        $auth->setStorage($sessionStorage);
        $auth->getStorage()->write($rememberMe);
    }

    /**
     * Register new user
     */
    public function registerAction()
    {
        // if the user is logged in, we don't need to register
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            // redirect to the login redirect route
            return $this->redirect()->toRoute($this->getOptions()
                ->getLoginRedirectRoute());
        }
        // if registration is disabled
        if (! $this->getOptions()->getEnableRegistration()) {
            return array(
                'enableRegistration' => false
            );
        }
        
        $request = $this->getRequest();
        $service = $this->getUserService();
        $form = $this->getRegisterForm();
        
        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $request->getQuery()->get('redirect')) {
            $redirect = $request->getQuery()->get('redirect');
        } else {
            $redirect = false;
        }
        
        $redirectUrl = $this->url()->fromRoute(static::ROUTE_REGISTER) . ($redirect ? '?redirect=' . rawurlencode($redirect) : '');
        // $prg = $this->prg($redirectUrl, true);var_dump();die;
        
        // if ($prg instanceof Response) {
        // return $prg;
        // } elseif ($prg === false) {
        // return array(
        // 'registerForm' => $form,
        // 'enableRegistration' => $this->getOptions()->getEnableRegistration(),
        // 'redirect' => $redirect
        // );
        // }
        
        $post = $this->getRequest()
            ->getPost()
            ->toArray(); // $prg;
        $user = $service->register($post);
        
        $redirect = isset($prg['redirect']) ? $prg['redirect'] : null;
        
        if (! $user) {
            return array(
                'registerForm' => $form,
                'enableRegistration' => $this->getOptions()->getEnableRegistration(),
                'redirect' => $redirect
            );
        }
        
        $service->generateTokenAndLogUserIdentity($user); // log registered user identity ...
        
        if ($service->getOptions()->getLoginAfterRegistration()) {
            $identityFields = $service->getOptions()->getAuthIdentityFields();
            if (in_array('email', $identityFields)) {
                $post['identity'] = $user->getEmail();
            } elseif (in_array('username', $identityFields)) {
                $post['identity'] = $user->getUsername();
            }
            $post['credential'] = $post['password'];
            $request->setPost(new Parameters($post));
            return $this->forward()->dispatch(static::CONTROLLER_NAME, array(
                'action' => 'authenticate'
            ));
        }
        
        // TODO: Add the redirect parameter here...
        return $this->redirect()->toUrl($this->url()
            ->fromRoute(static::ROUTE_LOGIN) . ($redirect ? '?redirect=' . rawurlencode($redirect) : ''));
    }

    /**
     * Change the users password
     */
    public function changepasswordAction()
    {
        // if the user isn't logged in, we can't change password
        if (! $this->zfcUserAuthentication()->hasIdentity()) {
            // redirect to the login redirect route
            return $this->redirect()->toRoute($this->getOptions()
                ->getLoginRedirectRoute());
        }
        
        $form = $this->getChangePasswordForm();
        $prg = $this->prg(static::ROUTE_CHANGEPASSWD);
        
        $fm = $this->flashMessenger()
            ->setNamespace('change-password')
            ->getMessages();
        if (isset($fm[0])) {
            $status = $fm[0];
        } else {
            $status = null;
        }
        
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return array(
                'status' => $status,
                'changePasswordForm' => $form
            );
        }
        
        $form->setData($prg);
        
        if (! $form->isValid()) {
            return array(
                'status' => false,
                'changePasswordForm' => $form
            );
        }
        
        if (! $this->getUserService()->changePassword($form->getData())) {
            return array(
                'status' => false,
                'changePasswordForm' => $form
            );
        }
        
        $this->flashMessenger()
            ->setNamespace('change-password')
            ->addMessage(true);
        return $this->redirect()->toRoute(static::ROUTE_CHANGEPASSWD);
    }

    public function changeEmailAction()
    {
        // if the user isn't logged in, we can't change email
        if (! $this->zfcUserAuthentication()->hasIdentity()) {
            // redirect to the login redirect route
            return $this->redirect()->toRoute($this->getOptions()
                ->getLoginRedirectRoute());
        }
        
        $form = $this->getChangeEmailForm();
        $request = $this->getRequest();
        $request->getPost()->set('identity', $this->getUserService()
            ->getAuthService()
            ->getIdentity()
            ->getEmail());
        
        $fm = $this->flashMessenger()
            ->setNamespace('change-email')
            ->getMessages();
        if (isset($fm[0])) {
            $status = $fm[0];
        } else {
            $status = null;
        }
        
        $prg = $this->prg(static::ROUTE_CHANGEEMAIL);
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return array(
                'status' => $status,
                'changeEmailForm' => $form
            );
        }
        
        $form->setData($prg);
        
        if (! $form->isValid()) {
            return array(
                'status' => false,
                'changeEmailForm' => $form
            );
        }
        
        $change = $this->getUserService()->changeEmail($prg);
        
        if (! $change) {
            $this->flashMessenger()
                ->setNamespace('change-email')
                ->addMessage(false);
            return array(
                'status' => false,
                'changeEmailForm' => $form
            );
        }
        
        $this->flashMessenger()
            ->setNamespace('change-email')
            ->addMessage(true);
        return $this->redirect()->toRoute(static::ROUTE_CHANGEEMAIL);
    }

    /**
     * Getters/setters for DI stuff
     */
    public function getUserService()
    {
        if (! $this->userService) {
            // $this->userService = $this->getServiceLocator()->get('zfcuser_user_service');
            $this->userService = $this->getServiceLocator()->get('examsqa_application_user_service');
        }
        return $this->userService;
    }

    public function setUserService(UserService $userService)
    {
        $this->userService = $userService;
        return $this;
    }

    public function getRegisterForm()
    {
        if (! $this->registerForm) {
            $this->setRegisterForm($this->getServiceLocator()
                ->get('zfcuser_register_form'));
        }
        return $this->registerForm;
    }

    public function setRegisterForm(Form $registerForm)
    {
        $this->registerForm = $registerForm;
    }

    public function getLoginForm()
    {
        if (! $this->loginForm) {
            $this->setLoginForm($this->getServiceLocator()
                ->get('zfcuser_login_form'));
        }
        return $this->loginForm;
    }

    public function setLoginForm(Form $loginForm)
    {
        $this->loginForm = $loginForm;
        $fm = $this->flashMessenger()
            ->setNamespace('zfcuser-login-form')
            ->getMessages();
        if (isset($fm[0])) {
            $this->loginForm->setMessages(array(
                'identity' => array(
                    $fm[0]
                )
            ));
        }
        return $this;
    }

    public function getChangePasswordForm()
    {
        if (! $this->changePasswordForm) {
            $this->setChangePasswordForm($this->getServiceLocator()
                ->get('zfcuser_change_password_form'));
        }
        return $this->changePasswordForm;
    }

    public function setChangePasswordForm(Form $changePasswordForm)
    {
        $this->changePasswordForm = $changePasswordForm;
        return $this;
    }

    /**
     * set options
     *
     * @param UserControllerOptionsInterface $options            
     * @return UserController
     */
    public function setOptions(UserControllerOptionsInterface $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * get options
     *
     * @return UserControllerOptionsInterface
     */
    public function getOptions()
    {
        if (! $this->options instanceof UserControllerOptionsInterface) {
            $this->setOptions($this->getServiceLocator()
                ->get('zfcuser_module_options'));
        }
        return $this->options;
    }

    /**
     * Get changeEmailForm.
     *
     * @return changeEmailForm.
     */
    public function getChangeEmailForm()
    {
        if (! $this->changeEmailForm) {
            $this->setChangeEmailForm($this->getServiceLocator()
                ->get('zfcuser_change_email_form'));
        }
        return $this->changeEmailForm;
    }

    /**
     * Set changeEmailForm.
     *
     * @param
     *            changeEmailForm the value to set.
     */
    public function setChangeEmailForm($changeEmailForm)
    {
        $this->changeEmailForm = $changeEmailForm;
        return $this;
    }

    public function editProfileAction()
    {
        // if the user is not logged in, redirect to home / login page
        if (! $this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser'); // redirect to the login redirect route
        }
        
        $request = $this->getRequest();
        $service = $this->getUserService();
        $form = $this->getServiceLocator()->get('examsqa_application_user_profile_form');
        
        if ($request->isPost()) {
            $post = $this->getRequest()
                ->getPost()
                ->toArray();
            $user = $service->editProfile($post);
        }
        
        $form->bind($this->zfcUserAuthentication()
            ->getIdentity());
        return new ViewModel(array(
            'editProfileForm' => $form
        ));
    }

    public function resetPassword()
    {}
}
