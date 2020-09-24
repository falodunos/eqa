<?php
namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Admin\Controller\InstitutionController as InstitutionControllerFromAdmin;

class InstitutionController extends InstitutionControllerFromAdmin
{

    protected $_zfcUserAuthentication;

    public function __construct($instService, $instForm)
    {
        parent::__construct($instService, $instForm);
    }

    public function entryAction()
    {
        $request = $this->getRequest();
        $htmlViewPart = new ViewModel();
        if ($request->isPost()) {
            $post = $request->getPost();
            $status = $this->_institutionService->saveInstitution($post);
            $status == true ? $this->flashMessenger()->addSuccessMessage('Request successfully completed!') : '';
            return $this->redirect()->toRoute('zfcuser');
        } else {
            is_null($this->getInstitutionFromAuthInstance()) == false ? $this->_institutionForm->bind($this->getInstitutionFromAuthInstance()):'';
            
            $userId = $this->zfcUserAuthentication()
            ->getIdentity()
            ->getId();
            
            $this->_institutionForm->get('institution-fieldset')
            ->get('user')
            ->setValue($userId);

            return $htmlViewPart->setVariables(array(
                'institutionForm' => $this->_institutionForm,
                'institutionExist' => $this->_institutionExist
            ));
        }
    }

    public function viewAction()
    {
        $identity = $this->zfcUserAuthentication()->getIdentity();
        $userId = $identity->getId();
        var_dump($userId);
        die();
    }
}
