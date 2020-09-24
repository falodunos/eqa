<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\Academic\InstitutionService;
use Admin\Form\Academic\InstitutionForm;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class InstitutionController extends AbstractActionController
{

    protected $_institutionService;

    protected $_institutionForm;

    protected $_institutionExist = false;

    public function __construct(InstitutionService $instService, InstitutionForm $instForm)
    {
        $this->_institutionService = $instService;
        $this->_institutionForm = $instForm;
        $this->_institutionExist = $this->_institutionService->checkIfInstitutionExist();
    }

    public function overviewAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/institution/overview.phtml')->setTerminal(true);
            
            return $htmlViewPart;
        }
        return array();
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $path = null;
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost()->toArray();
            $instHtml = $this->_institutionService->getInstHtml();
            return new JsonModel(array(
                'status' => true,
                'html' => $instHtml
            ));
        }
    }

    public function entryAction()
    {
        $request = $this->getRequest();
        $htmlViewPart = new ViewModel();
        $isXmlHttpRequest = $request->isXmlHttpRequest();
        $htmlViewPart->setTerminal($isXmlHttpRequest);
        
        if ($isXmlHttpRequest) {
            if ($request->isPost()) {
                $post = $request->getPost();
                $status = $this->_institutionService->saveInstitution($post);
                return new JsonModel(array(
                    'status' => $status
                ));
            } else {
                $params = $request->getQuery();
                if (isset($params['id'])) {
                    $instData = $this->_institutionService->getEntityDataArray($params['id']);
                    return new JsonModel($instData);
                }
                
                $userId = $this->zfcUserAuthentication()
                    ->getIdentity()
                    ->getId();
                $this->_institutionForm->get('institution-fieldset')
                    ->get('user')
                    ->setValue($userId);
                
                return $htmlViewPart->setVariables(array(
                    'institutionForm' => $this->_institutionForm
                ));
            }
        }
                return $htmlViewPart->setVariables(array(
                    'institutionForm' => $this->_institutionForm
                ));
    }

    public function updateActiveStatusAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $postData = $request->getPost()->toArray();
            $updateStatus = $this->_institutionService->updateActiveStatus($postData);
            return new JsonModel(array(
                'status' => $updateStatus == true ? true : false
            ));
        }
    }

    public function delete($id)
    {
        return array();
    }
    
    protected function getInstitutionFromAuthInstance()
    {
        if ($this->_institutionExist == true) {
            return $this->zfcUserAuthentication()
            ->getIdentity()
            ->getInstitution();
        } else {
            return null;
        }
    }
}
